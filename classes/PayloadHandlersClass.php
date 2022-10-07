<?php
class PayloadHandlersClass {
    private $queryHandler;
    public function __construct() {
        $this->queryHandler = new MessageHandlers;
    }
    public function EnterErrorMenuMethod($chatId, $text, $payload) {
        switch ($text) {
            case 'Способы решения':
                $code = $payload['code'];
                $errorObject = ErrorRegistryClass::$errors[$code];
                $text = $errorObject['solutions'] . PHP_EOL . $errorObject['components'];
                $timestamp = time();
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $request = new Request('sendPhoto', [
                    'chat_id' => $chatId,
                    'photo' => "https://bot.urentech.ru/utech-errorcode-bot/media/manuals/manual_$code.png?timestamp=$timestamp",
                    'caption' => $text,
                    'parse_mode' => 'HTML',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => $keyboard
                    ])
                ]);
                $request();
                return true;
                break;
            default:
                # code...
                break;
        }
    }
    public function EnterErrorCode($chatId, $text, $payload)
    {
        $code = $text;
        if (array_key_exists($code, ErrorRegistryClass::$errors)) {
            $errorObject =  ErrorRegistryClass::$errors[$code];
        } else {
            $text = sprintf(MessageRegistryClass::$messages['errorDoNotExists']['text'], $code);
            $this->queryHandler->errorDoNotExists($chatId, $text);
            die();
        }
        $payload = ['route' => 'EnterErrorMenuMethod', 'code' => $text];
        DataBaseHandlers::pushCallbackData($chatId, $payload);
        $keyboard = MessageRegistryClass::$messages['error']['keyboard'];
        $text = sprintf(MessageRegistryClass::$messages['error']['text'], $code) . PHP_EOL . $errorObject['text'];
        $this->queryHandler->getErrorHandler($chatId, $text, $keyboard);
    }
}