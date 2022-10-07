<?php
class MessageHandlers {
    public function getErrorsArrayHandler(String $chatId, String $text) {
        $keyboard = [[]];
        $maxButtonPerRow = 4;
        foreach (ErrorRegistryClass::$errors as $key => $value) {
            if (count($keyboard[array_key_last($keyboard)]) < $maxButtonPerRow) {
                array_push($keyboard[array_key_last($keyboard)], [
                    'text' => "$key"
                ]);
            } else {
                array_push($keyboard, []);
            }
        }
        array_push($keyboard, [['text' => "Назад"]]);
        $payload = ['route' => 'EnterErrorCode'];
        DataBaseHandlers::pushCallbackData($chatId, $payload);
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request();
        return true;
    }
    public function getErrorHandler(String $chatId, String $text, Array $keyboard) {
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request();
        return true;
    }
    public function errorDoNotExists(String $chatId, String $text) {
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
        $request();
    }
    public function errorCodeDoNotExists(String $chatId, String $text) {
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
        $request();
    }
    public function firstStartHandler(String $chatId, String $text, Array $keyboard) {
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request();
    }
    public function helpHandler(String $chatId, String $text, Array $keyboard) {
        $request = new Request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request();
    }
}