<?php
class Bot {
    private static $ver = '0.0.3';
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
            default:
                throw new Exception("Error route", 1);
                break;
        }
    }
    public function handleTextMessage($request) {
        if(!isset($this->chatId)) {
            return false;
        }
        $queryHandler = new MessageHandlersRegistry;
        $route = mb_strtolower(explode(' ', $this->text)[0]);
        switch ($route) {
            case '/start':
                $keyboard = KeyboardRegistryClass::$keyboards['basic']['keyboard'];
                $description = KeyboardRegistryClass::$keyboards['basic']['description'];
                $this->sendMessageWithKeyboard(new Request, $description, $keyboard);
                break;
            default:
                $queryHandler->unknownCommand(new Request, $this->chatId);
                break;
        }
    }
    public function pinChatMessage($request, String $messageId = null) {
        if ($messageId) {
            $request->set('pinChatMessage', ['chat_id' => $this->chatId, 'message_id' => $messageId]);
            $request->send();
            return true;
        }
        return false;
    }
    public function sendMessageWithKeyboard($request, String $text = null, Array $keyboard = null) {
        if ($text && $keyboard) {
            $replyKeyboardMarkup = json_encode([
                'keyboard' => $keyboard
            ]);
            $request->set('sendMessage', [
                'chat_id' => $this->chatId,
                'text' => $text,
                'reply_markup' => $replyKeyboardMarkup
            ]);
            $request->send();
            return true;
        }
        return false;
    }
    public function sendMessageWithInlineKeyboard($request, String $text = null, Array $keyboard = null) {
        if ($text && $keyboard) {
            $replyKeyboardMarkup = json_encode([
                'inline_keyboard' => $keyboard
            ]);
            $request->set('sendMessage', [
                'chat_id' => $this->chatId,
                'text' => $text,
                'reply_markup' => $replyKeyboardMarkup
            ]);
            $request->send();
            return true;
        }
        return false;
    }
}

?>