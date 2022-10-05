<?php
class QueryHandlersRegistry {
    public function queryTest ($request, $callbackQueryChatId) {
        $request->set('sendMessage', ['chat_id' => $callbackQueryChatId, 'text' => 'test']);
        $request->send();
    }
}