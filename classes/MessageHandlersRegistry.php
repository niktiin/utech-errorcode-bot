<?php
class MessageHandlersRegistry {
    public function errorsArrayHandler($request, String $chatId, String $text, Array $keyboard) {
        $request->set('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'inline_keyboard' => $keyboard
            ])
        ]);
        $request->send();
        return true;
    }
    public function errorHandler($request, String $chatId, String $text, Array $keyboard) {
        $request->set('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);
        $request->send();
        return true;
    }
    public function errorDoNotExists($request, String $chatId, String $text) {
        $request->set('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
        $request->send();
    }
    public function firstStartHandler($request, String $chatId, String $text, Array $keyboard) {
        $request->set('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request->send();
    }
    public function helpHandler($request, String $chatId, String $text, Array $keyboard) {
        $request->set('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard
            ])
        ]);
        $request->send();
    }
}