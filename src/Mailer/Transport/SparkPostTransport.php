<?php
declare(strict_types=1);

/*
 * Copyright (c) 2015 Syntax Era Development Studio
 *
 * Licensed under the MIT License (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 *      https://opensource.org/licenses/MIT
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace App\Mailer\Transport;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use SparkPost\SparkPost;
use SparkPost\SparkPostException;

/**
 * Spark Post Transport Class
 *
 * Provides an interface between the CakePHP Email functionality and the SparkPost API.
 *
 * @package SparkPost\Mailer\Transport
 *
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class SparkPostTransport extends AbstractTransport
{
    /**
     * Send mail via SparkPost REST API
     *
     * @param \Cake\Mailer\Email $email Email message
     *
     * @return void
     */
    public function send(Email $email): void
    {
        // Load SparkPost configuration settings
        $apiKey = Configure::read('SparkPost.Api.key');

        $httpClient = new GuzzleAdapter(new GuzzleClient());
        $sparky = new SparkPost($httpClient, ['key' => $apiKey]);

        // Pre-process CakePHP email object fields
        $from = (array)$email->getSender();
        $sender = sprintf('%s <%s>', array_values($from)[0], array_keys($from)[0]);
        $sendTo = (array)$email->getTo();
        $recipients = [[ 'address' => [ 'name' => array_values($sendTo)[0], 'email' => array_keys($sendTo)[0] ]]];

        // Build message to send
        $message = [
            'from' => $sender,
            'html' => empty($email->message('html')) ? $email->message('text') : $email->message('html'),
            'text' => $email->message('text'),
            'subject' => $email->getSubject(),
        ];

        $body = [
            'content' => $message,
            'recipients' => $recipients,
        ];

        $promise = $sparky->transmissions->post($body);

        try {
            $response = $promise->wait();

            /** @var \SparkPost\SparkPostResponse $response */
            $results = $response->getBody();
            /** @var \Cake\Mailer\Email $email */
            $sendHeaders = $email->getHeaders(['X-Email-Gen-Code', 'X-Gen-ID']);

            $this->EmailSends = TableRegistry::getTableLocator()->get('EmailSends');
            $this->EmailSends->sendRegister($results, $sendHeaders);
        } catch (SparkPostException $e) {
            Log::error($e->getCode());
        }
    }
}
