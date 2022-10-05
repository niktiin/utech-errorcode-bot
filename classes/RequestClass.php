<?php
class Request {
    private $options;
    private $url;
    private $method;
    private static $bot_api_key = '5717042067:AAGtinZODp2tYsLfREPP5bIB-4txC2LqD3g';
    public function __construct(String $method = '', Array $options = []) {
        $this->url = 'https://api.telegram.org/bot' . self::$bot_api_key . '/' . $method;
        $this->options = $options;
    }
    public function echo() {
        print_r(json_encode(['url'=> $this->url, 'options'=> $this->options]));
    }
    public function set(String $method = '', Array $options = []) {
        $this->url = 'https://api.telegram.org/bot' . self::$bot_api_key . '/' . $method;
        $this->options = $options;
    }
    public function send() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->options);
        $responce = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode != '200') {
            throw new Exception('{"text": "Telegram Bot API return server error!"}');
        }
        curl_close($ch);
        return $responce;
    }
}
?>