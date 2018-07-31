<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", '7b3670fe459ebc369420b231b149dc5e');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'ivs0Di9l7ocERtIF1C3ZJnotI3HMluaXBoXjIbltAYRaN0nO+MiiMf3/Tu8NkdJlSBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmvPv2m68MSBhB9SRGJQ/9zaDkPJF2q3Cx2QUk+Ugwt0PAdB04t89/1O/w1cDnyilFU=');

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