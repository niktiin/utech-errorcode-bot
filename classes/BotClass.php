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
        $this->callbackQuery = $this->update['callback_query'];
        $this->callbackQueryChatId = $this->update['callback_query']["from"]["id"];
        $this->data = json_decode($this->callbackQuery['data']);
    }
    public function handleCallbackQuery($request) {
        if(!isset($this->callbackQueryChatId)) {
            return false;
        }
        $queryHandler = new QueryHandlersRegistry;
        switch ($this->data->route) {
            case 'route_testQuery':
                $queryHandler->queryTest(new Request, $this->callbackQueryChatId);
                break;
            case 'route_getError':
                $errorObject = MessageRegistryClass::getError($this->data->code);
                if (!$errorObject) {
                    $text = sprintf(MessageRegistryClass::$messages['errorDoNotExists']['text'], $this->data->code);
                    $queryHandler->errorDoNotExists(new Request, $this->callbackQueryChatId, $text);
                    die();
                }
                $keyboard = MessageRegistryClass::$messages['errorsArrayHideKeyboard']['keyboard'];
                $messageId = intval($this->callbackQuery['message']['message_id']);
                $text = MessageRegistryClass::$messages['errorsArrayHideKeyboard']['text'];
                $queryHandler->errorsArrayEditMessage(new Request, $this->callbackQueryChatId, $messageId, $text, $keyboard);

                $keyboard = MessageRegistryClass::getErrorKeyboard($this->data->code);
                $text = sprintf(MessageRegistryClass::$messages['error']['text'], $this->data->code) . PHP_EOL . $errorObject['text'];
                $queryHandler->errorHandler(new Request, $this->callbackQueryChatId, $text, $keyboard);
                break;
            case 'route_getSolutions':
                $errorObject = MessageRegistryClass::getError($this->data->code);
                $text = $errorObject['solutions'];
                $queryHandler->getSolutionsHandler(new Request, $this->callbackQueryChatId, $text, $this->data->code);
                break;
            case 'route_getComponents':
                $errorObject = MessageRegistryClass::getError($this->data->code);
                $text = $errorObject['components'];
                $queryHandler->getComponentsHandler(new Request, $this->callbackQueryChatId, $text, $this->data->code);
                break;
            case 'route_hideErrorsArray':
                $keyboard = MessageRegistryClass::$messages['errorsArrayHideKeyboard']['keyboard'];
                $messageId = intval($this->callbackQuery['message']['message_id']);
                $text = MessageRegistryClass::$messages['errorsArrayHideKeyboard']['text'];
                $queryHandler->errorsArrayEditMessage(new Request, $this->callbackQueryChatId, $messageId, $text, $keyboard);
                break;
            case 'route_showErrorsArray':
                $messageId = intval($this->callbackQuery['message']['message_id']);
                $keyboard = MessageRegistryClass::getErrorsArray()['keyboard'];
                $text = MessageRegistryClass::getErrorsArray()['text'];
                $queryHandler->errorsArrayEditMessage(new Request, $this->callbackQueryChatId, $messageId, $text, $keyboard);
                break;
            default:
                throw new Exception("Error route", 1);
                break;
        }
        $queryHandler->answerCallbackQuery(new Request, $this->callbackQuery['id']);
    }
    public function handleTextMessage($request) {
        if(!isset($this->chatId)) {
            return false;
        }
        $queryHandler = new MessageHandlersRegistry;
        $route = mb_strtolower(explode(' ', $this->text)[0]);
        $payload = mb_strtolower(explode(' ', $this->text)[1]);
        switch ($route) {
            case '/start':
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->firstStartHandler(new Request, $this->chatId, $text, $keyboard);
                break;
            case '/помощь':
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->helpHandler(new Request, $this->chatId, $text, $keyboard);
                break;
            case '/ошибки':
                $keyboard = MessageRegistryClass::getErrorsArray()['keyboard'];
                $text = MessageRegistryClass::getErrorsArray()['text'];
                $queryHandler->errorsArrayHandler(new Request, $this->chatId, $text, $keyboard);
                break;
            case '/ошибка':
                $errorObject = MessageRegistryClass::getError($payload);
                if (!$errorObject) {
                    $text = sprintf(MessageRegistryClass::$messages['errorDoNotExists']['text'], $payload);
                    $queryHandler->errorDoNotExists(new Request, $this->chatId, $text);
                    die();
                }
                $keyboard = MessageRegistryClass::$messages['error']['keyboard'];
                $text = sprintf(MessageRegistryClass::$messages['error']['text'], $payload) . PHP_EOL . $errorObject['text'];
                $queryHandler->errorHandler(new Request, $this->chatId, $text, $keyboard);
                break;
            default:
                $keyboard = MessageRegistryClass::$messages['basic']['keyboard'];
                $text = MessageRegistryClass::$messages['basic']['text'];
                $queryHandler->helpHandler(new Request, $this->chatId, $text, $keyboard);
                break;
        }
    }
}

?>