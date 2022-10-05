<?php
require_once('classes/BotClass.php');
require_once('classes/ErrorRegistryClass.php');
require_once('classes/RequestClass.php');
require_once('classes/QueryHandlersRegistry.php');
require_once('classes/MessageHandlersRegistry.php');
require_once('classes/KeyboardRegistryClass.php');
$bot = new Bot();
try {
    $bot->handleCallbackQuery(new Request);
    $bot->handleTextMessage(new Request);
} catch (Exception $e) {
    $ExceptionRequest = new Request('sendMessage', [
        'chat_id' => $bot->chatId,
        'text' => '<code>' . $e->getMessage() . '</code>',
        'parse_mode' => 'HTML'
    ]);
    $ExceptionRequest->send();
    die();
} catch (Error $e) {
    $ExceptionRequest = new Request('sendMessage', [
        'chat_id' => $bot->chatId,
        'text' => '<code>' . $e->getMessage() . '</code>',
        'parse_mode' => 'HTML'
    ]);
    $ExceptionRequest->send();
    die();
}
