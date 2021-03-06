<?php
    require __DIR__ . '/vendor/autoload.php';

    use \LINE\LINEBot;
    use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
    use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
    use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
    use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
    use \LINE\LINEBot\SignatureValidator as SignatureValidator;
     
    // set false for production
    $pass_signature = true;
     
    // set LINE channel_access_token and channel_secret
    $channel_access_token = "ivs0Di9l7ocERtIF1C3ZJnotI3HMluaXBoXjIbltAYRaN0nO+MiiMf3/Tu8NkdJlSBSSWo3zea72fERCvIkSUsyQMOJ9YgN2rPq4+kVYnmvPv2m68MSBhB9SRGJQ/9zaDkPJF2q3Cx2QUk+Ugwt0PAdB04t89/1O/w1cDnyilFU=";
    $channel_secret = "7b3670fe459ebc369420b231b149dc5e";
     
    // inisiasi objek bot
    $httpClient = new CurlHTTPClient($channel_access_token);
    $bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
     
    $configs =  [
        'settings' => ['displayErrorDetails' => true],
    ];
    $app = new Slim\App($configs);
     
    // buat route untuk url homepage
    $app->get('/', function($req, $res)
    {
      echo "Welcome at Slim Framework";
    });
     
    // buat route untuk webhook
    $app->post('/webhook', function ($request, $response) use ($bot, $pass_signature)
    {
        // get request body and line signature header
        $body        = file_get_contents('php://input');
        $signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';
     
        // log body and signature
        file_put_contents('php://stderr', 'Body: '.$body);
     
        if($pass_signature === false)
        {
            // is LINE_SIGNATURE exists in request header?
            if(empty($signature)){
                return $response->withStatus(400, 'Signature not set');
            }
     
            // is this request comes from LINE?
            if(! SignatureValidator::validateSignature($body, $channel_secret, $signature)){
                return $response->withStatus(400, 'Invalid signature');
            }
        }
     
        // kode aplikasi nanti disini
        $data = json_decode($body, true);
        foreach($data['events'] as $event) {
        	$result = $bot->replyText($event['replyToken'], 'reply via slim');
     		// nanti bisa diganti pakai message builder
	     	return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
        }
    });

    $app->get('/rogerHalo', function($req, $res) use ($bot){
    	$rogerId = 'U7132d293775a90cddb30d9762ac2646a';
    	$msg = new TextMessageBuilder("Roger, Roger");
    	$result = $bot->pushMessage($rogerId, $msg);

    	return $res->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
    });

    $app->get('/vilatHalo', function($req, $res) use ($bot){
    	$vilatId = 'U7e0b726622d3afb0050fc1f2d1b8b2cb';
    	$msg = new TextMessageBuilder("Halo Vilat! :D");
    	$result = $bot->pushMessage($vilatId, $msg);

    	return $res->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
    });

     
    $app->run();