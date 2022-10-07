<?php
/**
 * PRINT ERROR CONFIG
 */
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/**
 *  REQUIRE FILE
 */
require_once('classes/BotClass.php');
require_once('classes/RequestClass.php');
require_once('classes/DataBaseHandlersClass.php');
require_once('classes/MessageHandlersClass.php');
require_once('classes/MessageRegistryClass.php');
require_once('classes/PayloadHandlersClass.php');
require_once('classes/ErrorRegistryClass.php');

$bot = new Bot();
try {
    $payload = DataBaseHandlers::FindPayloadByChatId($bot->chatId);
    if ($payload) {
        $bot->handlePayload($payload);
        die();
    }
    $bot->handleTextMessage();
} catch (Exception $e) {
    $ExceptionRequest = new Request('sendMessage', [
        'chat_id' => $bot->chatId,
        'text' => '<code>' . $e->getMessage() . '</code>',
        'parse_mode' => 'HTML'
    ]);
    $ExceptionRequest();
    die();
} catch (Error $e) {
    $ExceptionRequest = new Request('sendMessage', [
        'chat_id' => $bot->chatId,
        'text' => '<code>' . $e->getMessage() . '</code>',
        'parse_mode' => 'HTML'
    ]);
    $ExceptionRequest();
    die();
}

?>