<?php

class DataBaseHandlers {
    public static function pushCallbackData($chatId, $payload) {
        $payloadJSON = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $mysqli = new mysqli("localhost", "j77441610", "j77441610u", "j77441610_errorcode-bot");
        $result = $mysqli->query("INSERT INTO `callbackqueries` (`chatId`, `payload`) VALUES ('$chatId', '$payloadJSON') ON DUPLICATE KEY UPDATE payload = '$payloadJSON'");
        $mysqli->close();
        return $result;
    }
    public static function FindPayloadByChatId($chatId) {
        $mysqli = new mysqli("localhost", "j77441610", "j77441610u", "j77441610_errorcode-bot");
        $result = $mysqli->query("SELECT `payload` FROM `callbackqueries` WHERE chatId = '$chatId'");
        if($result->num_rows > 0) {
            $mysqli->query("DELETE FROM `callbackqueries` WHERE chatId = '$chatId'");
            $mysqli->close();
            return json_decode($result->fetch_assoc()['payload'], JSON_UNESCAPED_SLASHES);
        }
        $mysqli->close();
        return false;
    }
}