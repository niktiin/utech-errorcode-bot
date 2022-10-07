<?php
class Bot {
    private static $ver = '0.0.4';
    public $update;
    public $chatId;
    public $message;
    public $text;
    public $callbackQuery;
    public $callbackQueryChatId;
    public $data;
    public function __construct() {
        $content = file_get_contents("php://input");
        $this->update = json_decode($content, TRUE);
        $this->message = $this->update["message"];
        $this->chatId = $this->message["chat"]["id"];
        $this->text = $this->message["text"];
    }
    public function handlePayload($payload)
    {
        $payloadHandler = new PayloadHandlersClass;
        $payloadHandlerName = $payload['route'];
        $payloadHandler->$payloadHandlerName($this->chatId, $this->text, $payload);
    }
    public function handleTextMessage() {
        if(!isset($this->chatId)) {
            return false;
        }
        $queryHandler = new MessageHandlers;
        $route = mb_strtolower(explode(' ', $this->text)[0]);
        $payload = mb_strtolower(explode(' ', $this->text)[1]);
        switch ($route) {
            case '/start':
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->firstStartHandler($this->chatId, $text, $keyboard);
                break;
            case '/помощь':
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->helpHandler($this->chatId, $text, $keyboard);
                break;
            case '/ошибки':
                $text = MessageRegistryClass::$messages['errorsArray']['text'];
                $queryHandler->getErrorsArrayHandler($this->chatId, $text);
                break;
            case '/ошибка':
                if (mb_strlen($payload) < 1) {
                    $text = MessageRegistryClass::$messages['errorCodeDoNotExists']['text'];
                    $queryHandler->errorCodeDoNotExists($this->chatId, $text);
                    die();
                }
                $code = $payload;
                if (array_key_exists($code, ErrorRegistryClass::$errors)) {
                    $errorObject =  ErrorRegistryClass::$errors[$code];
                } else {
                    $text = sprintf(MessageRegistryClass::$messages['errorDoNotExists']['text'], $payload);
                    $queryHandler->errorDoNotExists($this->chatId, $text);
                    die();
                }
                $keyboard = MessageRegistryClass::$messages['error']['keyboard'];
                $text = sprintf(MessageRegistryClass::$messages['error']['text'], $payload) . PHP_EOL . $errorObject['text'];
                $queryHandler->getErrorHandler($this->chatId, $text, $keyboard);
                break;
            default:
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->helpHandler($this->chatId, $text, $keyboard);
                break;
        }
    }
}

?>