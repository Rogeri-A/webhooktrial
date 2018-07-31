<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", '35c979166caed23f3f3d7a4cfb4bde9e');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'dTTPJ6o2wb1XwlgIE73EzyWaW0czeWNaEEa8o2ynKhXkid47mmBMkjO2VXdjO9mJSBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmvO+mjud/KoDeCasYcUiVIgnx75X4MOf2TbtsX6MbI/7AdB04t89/1O/w1cDnyilFU=');

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