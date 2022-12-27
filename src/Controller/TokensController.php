<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\QueueComponent;
use App\Model\Entity\Token;
use App\Model\Table\TokensTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Exception;

/**
 * Tokens Controller
 *
 * @property TokensTable $Tokens
 * @property QueueComponent $Queue
 * @method Token[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class TokensController extends AppController
{
    /**
     * @throws Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['validate']);
        $this->Authorization->skipAuthorization();
    }

    /**
     * Validation of a Token
     *
     * @param string $token The Token for deciphering.
     * @return Response|null
     */
    public function validate($token = null)
    {
        // Kick if no Token
        if (is_null($token)) {
            return $this->redirect($this->referer('/'));
        }

        // Validate Token
        $validated = $this->Tokens->validateToken($token);

        if (!is_numeric($validated) || (!$validated && is_bool($validated))) {
            $this->Flash->error('This Token is Invalid');

            return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
        }

        if (is_numeric($validated)) {
            $tokenRow = $this->Tokens->get($validated, ['contain' => 'EmailSends']);
            $header = $tokenRow->get('token_header');

            if (key_exists('authenticate', $header) && $header['authenticate']) {
                $transactor = $this->Tokens->EmailSends->Users->get($tokenRow->email_send->user_id);
                $this->Authentication->setIdentity($transactor);
            }

            if (key_exists('redirect', $header)) {
                $location = $header['redirect'];
                $tokenReData = [
                    '?' => [
                        'token_id' => $validated,
                        'token' => urldecode($token),
                    ],
                ];
                $redirect = array_merge($location, $tokenReData);

                return $this->redirect($redirect);
            }
        }

        return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
    }

    /**
     * @param int|null $tokenId Token ID to be deactivated
     * @return Response
     */
    public function inactivate($tokenId = null): Response
    {
        $token = $this->Tokens->get($tokenId);

        if ($this->request->is('post')) {
            $token->set($token::FIELD_ACTIVE, false);
            if ($this->Tokens->save($token)) {
                $this->Flash->success('Token Inactivated');
            }
        }

        return $this->redirect($this->referer([
            'controller' => 'EmailSends',
            'action' => 'view',
            $token->email_send_id,
        ]));
    }

    /**
     * Process method
     *
     * @param int|string|null $tokenId The Optional ID of the Token
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException|Exception When record not found.
     */
    public function parse($tokenId = null)
    {
        $this->request->allowMethod(['post']);

        if (isset($tokenId) && !empty($tokenId)) {
            $token = $this->Tokens->get($tokenId);
            $response = $this->Tokens->cleanToken($token);

            if ($response == $this->Tokens::CLEAN_DELETED) {
                $this->Flash->error('Token Deleted');
            } elseif ($response == $this->Tokens::CLEAN_DEACTIVATE) {
                $this->Flash->warning('Token Deactivated');
            } else {
                $this->Flash->success('No Action Taken');
            }

            return $this->redirect($this->referer(['controller' => 'Admin', 'action' => 'index']));
        }

        $this->loadComponent('Queue');
        $this->Queue->setTokenParse();

        return $this->redirect($this->referer(['controller' => 'Admin', 'action' => 'index']));
    }
}
