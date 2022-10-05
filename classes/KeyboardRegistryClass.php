<?php

class KeyboardRegistryClass {

    public static $keyboards = [
        'basic' => [
            'keyboard' => [
                [['Список ошибок']]
            ],
            'descrition' => 'Ремонт бот, твой не заменимый помощник в ремонте! Основное меню:'
        ],
        'ErrorSub' => [
            'keyboard' => [],
            'description' => 'Ошибки для моделей: G30, Max Plus, Max Plus X. Основные неисправности и способы их решения.'
        ]
    ];

    final public static function get($key)
    {
        if (!isset(self::$keyboards[$key])) {
            return false;
        }

        return self::$keyboards[$key];
    }
    final public static function setErrorSubKeyboard() {
        foreach (ErrorRegistryClass::$errors as $key => $value) {
            array_push(self::$keyboards['ErrorSub']['keyboard'], [["$key — $value"]]);
        }
    }
}