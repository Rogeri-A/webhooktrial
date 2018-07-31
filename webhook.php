<?php
/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
require_once('./LINEBotTiny.php');

$channelAccessToken = 'fMqODiIJG3EdDbp8OoiL0YjHN0r2ZkeZhcLZ7ulPZ904dV5RpUIMwk9Eb74d/2q3SBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmsWgsEoU9tm+sx/CfzjJ52aXZgalvN6qY0miMPVvJ7LqwdB04t89/1O/w1cDnyilFU=';
$channelSecret = '35c979166caed23f3f3d7a4cfb4bde9e';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $message['text']
                            )
                        )
                    ));
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};