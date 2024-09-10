<?php

namespace Model;


class SingleToneErrorsFightGame {

    private static $_instance;
    private static array $errors;
    private static $init_errors;
    private const PATTERN_ERROR =  "the input do not match the pattern";
    private const PLAYER_NUMBER_ERROR = "strictly 2 player is allows";
    
    private function __construct($init_error)
    {
        self::$errors['PATTERN_ERROR'] = self::PATTERN_ERROR;
        self::$errors['PLAYER_NUMBER_ERROR'] = self::PLAYER_NUMBER_ERROR;
        self::$init_errors = $init_error;
    }

    private static function init($init_error):self
    {
        if(self::isnotInit())
        {
            self::$_instance = new self($init_error);
        }
        return self::$_instance;
    }

    public static function isNotInit():bool{
        return is_null((self::$_instance));
    }

    public static function getinitError(){
        return self::$errors[self::$init_errors];
    }

    public static function initError(string $errorName):void{
        self::init($errorName);
    }


}