<?php
class QueryHandlersRegistry {
    public function queryTest ($request, $callbackQueryChatId) {
        $request->set('sendMessage', ['chat_id' => $callbackQueryChatId, 'text' => 'test']);
        $request->send();
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
    public function answerCallbackQuery($request, String $callbackQueryId) {
        // $request->set('answerCallbackQuery', [
        //     'callback_query_id' => $callbackQueryId,
        //     'show_alert' => false,
        // ]);
        // $request->send();
        return true;
    }
    public function getSolutionsHandler($request, String $chatId, String $text, $code) {
        $timestamp = time();
        $request->set('sendPhoto', [
            'chat_id' => $chatId,
            'photo' => "https://bot.urentech.ru/utech-errorcode-bot/media/manuals/manual_$code.png?timestamp=$timestamp",
            'caption' => $text,
            'parse_mode' => 'HTML',
        ]);
        $request->send();
        return true;
    }
    public function getComponentsHandler($request, String $chatId, String $text, $code) {
        $timestamp = time();
        $request->set('sendPhoto', [
            'chat_id' => $chatId,
            'photo' => "https://bot.urentech.ru/utech-errorcode-bot/media/components/components_$code.png?timestamp=$timestamp",
            'caption' => $text,
            'parse_mode' => 'HTML',
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
    public function errorsArrayEditMessage($request, String $chatId, String $messageId, String $text, Array $keyboard) {
        $request->set('editMessageText', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);
        $request->send();
        return true;
    }

}