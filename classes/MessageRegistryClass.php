<?php

class MessageRegistryClass {

    public static $messages = [
        'basic' => [
            'keyboard' => [
                [['text' => '/ошибки']],
                [['text' => '/помощь']]
            ],
            'text' => <<< END
                🔧 Ремонт бот, твой не заменимый помощник в ремонте!\n
                Команды:
                <code>/ошибки</code> <i>— Список всех ошибок.</i>
                <code>/ошибка {число}</code> <i>— Информация об ошибке и способы ее устранения. Вместо <code>{число}</code> ввидите номер ошибки.</i>
                <code>/помощь</code> <i>— Выводит это сообщение.</i>
                END
        ],
        'errorsArray' => [
            'keyboard' => [],
            'text' => 'Ошибки для моделей: G30, Max Plus, Max Plus X. Основные неисправности и способы их решения.'
        ],
        'errorsArrayHideKeyboard' => [
            'keyboard' => [
                [['text' => 'Показать ошибки...', 'callback_data' => '{"route": "route_showErrorsArray"}']]
            ],
            'text' => 'Ошибки для моделей: G30, Max Plus, Max Plus X. Основные неисправности и способы их решения.'
        ],
        'error' => [
            'keyboard' => [
                [['text' => 'Способы решения', 'callback_data' => '{"route": "route_getSolutions", "code": "%s"}']],
                [['text' => 'Что нужно для ремонта', 'callback_data' => '{"route": "route_getComponents", "code": "%s"}']]
            ],
            'text' => 'Описание ошибки <code>#%s</code>:'
        ],
        'errorDoNotExists' => [
            'text' => 'Ошибка <code>#%s</code> не найдена!'
        ]
    ];

    final public static function get($key)
    {
        if (!isset(self::$messages[$key])) {
            return false;
        }

        return self::$messages[$key];
    }
    final public static function getErrorsArray() {
        foreach (ErrorRegistryClass::$errors as $key => $value) {
            array_push(self::$messages['errorsArray']['keyboard'], [[
                'text' => "$key — $value[desc]",
                'callback_data' => '{"route": "route_getError", "code": "' . $key . '"}'
            ]]);
        }
        array_push(self::$messages['errorsArray']['keyboard'], [[
            'text' => "Скрыть ошибки...",
            'callback_data' => '{"route": "route_hideErrorsArray"}'
        ]]);
        return  self::$messages['errorsArray'];
    }
    final public static function getError(String $code) {
        if(array_key_exists($code, ErrorRegistryClass::$errors)) {
            return  ErrorRegistryClass::$errors[$code];
        } else {
            return false;
        }
    }
    final public static function getErrorKeyboard(String $code) {
        self::$messages['error']['keyboard'][0][0]['callback_data'] = sprintf(self::$messages['error']['keyboard'][0][0]['callback_data'], $code);
        self::$messages['error']['keyboard'][1][0]['callback_data'] = sprintf(self::$messages['error']['keyboard'][1][0]['callback_data'], $code);
        return self::$messages['error']['keyboard'];
    }
}