<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", 'fMqODiIJG3EdDbp8OoiL0YjHN0r2ZkeZhcLZ7ulPZ904dV5RpUIMwk9Eb74d/2q3SBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmsWgsEoU9tm+sx/CfzjJ52aXZgalvN6qY0miMPVvJ7LqwdB04t89/1O/w1cDnyilFU=');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", '35c979166caed23f3f3d7a4cfb4bde9e');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";