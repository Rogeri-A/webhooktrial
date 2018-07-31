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

$channelAccessToken = 'ivs0Di9l7ocERtIF1C3ZJnotI3HMluaXBoXjIbltAYRaN0nO+MiiMf3/Tu8NkdJlSBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmvPv2m68MSBhB9SRGJQ/9zaDkPJF2q3Cx2QUk+Ugwt0PAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '7b3670fe459ebc369420b231b149dc5e';

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
                                'text' => "anda mengirimkan : ". $message['text']
                            )
                            , array(
                                'type' => 'text'
                                , 'text' => print_r($message['source'])
                            )
                        )
                    ));
                    // $client->replyMessage(array(
                    //     'replyToken' => $event['replyToken']
                    //     , 'messages'
                    // ));
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
