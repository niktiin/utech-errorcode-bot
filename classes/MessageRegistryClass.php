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
            'text' => '⚠ Ошибки для моделей: G30, Max Plus, Max Plus X. Выберете код ошибки из меню или введите вручную:'
        ],
        'errorsArrayHideKeyboard' => [
            'keyboard' => [
                [['text' => 'Показать ошибки...']]
            ],
            'text' => 'Ошибки для моделей: G30, Max Plus, Max Plus X. Основные неисправности и способы их решения.'
        ],
        'error' => [
            'keyboard' => [
                [['text' => 'Способы решения']]
            ],
            'text' => 'Описание ошибки <code>#%s</code>:'
        ],
        'errorCodeDoNotExists' => [
            'text' => 'Пожалуйста после команды "<code>/ошибка</code>" ввидите код ошибки, например: "<code>/ошибка 10</code>"'
        ],
        'errorDoNotExists' => [
            'text' => 'Ошибка <code>#%s</code> не существует, чтобы посмотреть список ошибок ввидите — "<code>/ошибки</code>", или воспользуйтесь меню'
        ]
    ];

    final public static function get($key)
    {
        if (!isset(self::$messages[$key])) {
            return false;
        }

        return self::$messages[$key];
    }
    final public static function getErrorKeyboard(String $code) {
        self::$messages['error']['keyboard'][0][0]['callback_data'] = sprintf(self::$messages['error']['keyboard'][0][0]['callback_data'], $code);
        self::$messages['error']['keyboard'][1][0]['callback_data'] = sprintf(self::$messages['error']['keyboard'][1][0]['callback_data'], $code);
        return self::$messages['error']['keyboard'];
    }
}