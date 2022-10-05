<?php
class MessageHandlersRegistry {
    public function handleErrorInfoCommand($request, String $chatId, String $text) {
        $errorNo = explode(' ', $text)[1];
        if (isset($errorNo)) {
            $errorData = ErrorRegistryClass::get($errorNo);
            if($errorData === false) {
                $request->set('sendMessage', ['chat_id' => $chatId, 'text' => 'Неизвестная ошибка']);
                $request->send();
                return false;
            }
            $request->set('sendMessage', ['chat_id' => $chatId, 'text' => $errorData['errorText']]);
            $request->send();
            return true;
        }
        $request->set('sendMessage', ['chat_id' => $chatId, 'text' => 'Укажите ошибку, например: "/ошибка 10"']);
        $request->send();
        return false;
    }
    public function unknownCommand($request, String $chatId) {
        $request->set('sendMessage', ['chat_id' => $chatId, 'text' => 'Неизвестная команда']);
        $request->send();
    }
}