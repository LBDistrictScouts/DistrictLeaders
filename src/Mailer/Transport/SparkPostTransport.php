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

use App\Model\Table\EmailSendsTable;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Message;
use Cake\ORM\Locator\LocatorAwareTrait;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use SparkPost\SparkPost;
use SparkPost\SparkPostException;
use SparkPost\SparkPostResponse;

/**
 * Spark Post Transport Class
 *
 * Provides an interface between the CakePHP Email functionality and the SparkPost API.
 *
 * @package SparkPost\Mailer\Transport
 * @property EmailSendsTable $EmailSends
 */
class SparkPostTransport extends AbstractTransport
{
    use LocatorAwareTrait;

    /**
     * Send mail via SparkPost REST API
     *
     * @param Message $emailMessage Email message
     * @return array
     */
    public function send(Message $emailMessage): array
    {
        // Load SparkPost configuration settings
        $apiKey = Configure::read('SparkPost.Api.key');

        $httpClient = new GuzzleAdapter(new GuzzleClient());
        $sparky = new SparkPost($httpClient, ['key' => $apiKey]);

        // Pre-process CakePHP email object fields
        $from = (array)$emailMessage->getSender();
        $sender = sprintf('%s <%s>', array_values($from)[0], array_keys($from)[0]);
        $sendTo = (array)$emailMessage->getTo();
        $recipients = [[ 'address' => [ 'name' => array_values($sendTo)[0], 'email' => array_keys($sendTo)[0] ]]];

        // Build message to send
        $message = [
            'from' => $sender,
            'html' => empty($emailMessage->getBodyHtml()) ? $emailMessage->getBodyText() : $emailMessage->getBodyHtml(),
            'text' => $emailMessage->getBodyText(),
            'subject' => $emailMessage->getSubject(),
        ];

        $body = [
            'content' => $message,
            'recipients' => $recipients,
        ];

        $promise = $sparky->transmissions->post($body);

        try {
            $response = $promise->wait();
            /** @var SparkPostResponse $response */

            $results = $response->getBody();
            $sendHeaders = $emailMessage->getHeaders(['X-Email-Gen-Code', 'X-Gen-ID']);

            $this->EmailSends = $this->getTableLocator()->get('EmailSends');
            $this->EmailSends->sendRegister($results, $sendHeaders);

            return [
                'headers' => $sendHeaders,
                'message' => $results,
            ];
        } catch (SparkPostException $e) {
            Log::error((string)$e->getCode());

            return [
                'headers' => 'Fail',
                'message' => 'Error',
            ];
        }
    }
}
