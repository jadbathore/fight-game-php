<?php

namespace Model;

use Model\ErrorsFightGame;

/**
* @namespace Model
* @extend ErrorFightGame
* @class AbstractioPlayer classe permettant d'implémenter de manière abstraite des paramètre
* @param array $playerA correspondant Au premier joueur 1 ici "Bob"
* @param array $playerB correspondant Au premier joueur 1 ici "Alice"
* @construct permet de construire les joueurs utilise un try catch cette méthode attrape tout les throw lancer par la @method setter() cela permet
* de ne pas construire la class si une exception est levée et de à la place instancier la protected static $error de son parent ErrorFightGame
 */
abstract class AbstractPlayer extends ErrorsFightGame {
    private array $playerA;
    private array $playerB;
    
    public function __construct(
        public string $input
    )
    {
        try{
            $this->playerA = $this->setter($input)[0];
            $this->playerB = $this->setter($input)[1];
        } catch (\Exception $e){
            $this->setError($e->getMessage());
        }
    }
    
    /**
    * @public setter permet de instancier les paramètres injectable $playerA et playerB
    * @param string $input le text brut
    * @throw Exception si on retrouve plus de 2 player c'est à dire le text possède plus de 1 '\n' et également si les informations de chaque joueur ne respecte pas la regex:
    * - '/([A-Z])\w+.[0-9].{0,3}([0-9].{0,2}){2}/i'
    * - doit respecter <string><int(entre1et3)><int(entre1et2)><int(entre1et2)>(si on fait (Bob a 7 4) par exemple une exception est lancer)
    * @return array
     */
    public function setter(string $input):array
    {
        $rawPlayerInfo =  preg_split('/\n/',$input,0);
        if(count($rawPlayerInfo) == 2)
        {
            $i = 0;
            foreach($rawPlayerInfo as $player)
                {
                    $regex = '/([A-Z])\w+.[0-9].{0,3}([0-9].{0,2}){2}/i';
                    if(preg_match($regex, $player))
                    {
                        $infos = explode(' ',$player);
                        $table[$i]['name'] = current($infos);
                        $table[$i]['pv'] =  next($infos);
                        $table[$i]['att'] = next($infos);
                        $table[$i]['def'] = next($infos);
                        $i++;
                    } else {
                        throw new \Exception(parent::PATTERN_ERROR);
                        break;
                    }
                }
        } else {
            throw new \Exception(parent::PLAYER_NUMBER_ERROR);
        }
        return $table;
    }

    /**
    * @public méthode permettant de retourner le paramètre injectable playerA
    * @return array
    */
    public function getterplayerA():array{
        return $this->playerA;
    }
    
    /**
    * @public méthode permettant de retourner le paramètre injectable playerB
    * @return array
    */
    public function getterplayerB():array{
        return $this->playerB;
    }
}
