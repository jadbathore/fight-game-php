<?php

namespace Model;


/**
* @namespace Model
* @class ErrorFightGame contenant tous les messages envoyer par les exceptions
* @param static protected $error
* @const PATTERN_ERROR
* @cosnt PLAYER_NUMBER_ERROR
 */
class ErrorsFightGame {

    static protected $error;

    const PATTERN_ERROR =  "the input do not match the pattern";
    const PLAYER_NUMBER_ERROR = "strictly 2 player is allows";
    
    /**
    * @public instancie la static error
    * @return void
    */
    public function setError($message):void
    {
        self::$error = $message;
    }
}