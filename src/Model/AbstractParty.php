<?php

namespace Model;

use Exception;
use Model\SingleToneErrorsFightGame;
use Model\Player;


/**
 * @class represantant une partie abstrate qui sera composé de 2 objet joueur 
 */
abstract class AbstractParty {

    private Player $playerA;
    private Player $playerB;
    
    public function __construct(
        public string $input
    )
    {
        try{
            $this->playerA = new Player($this->setter($input)[0]);
            $this->playerB = new Player($this->setter($input)[1]);
        }catch(Exception $e){
            SingleToneErrorsFightGame::initError($e->getMessage());
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
    private function setter(string $input):array
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
                        ;
                        throw new Exception('PATTERN_ERROR');
                        break;
                    }
                }
        } else {
            throw new Exception('PLAYER_NUMBER_ERROR');
        }
        return $table;
    }

    /**
     * @abstract round prédefini de manière abstrait forcant les class enfant a utilisé cette methode de cette manière;
     */
    abstract public function round(Player $playerA,Player $playerB);


    public function swapPlayer(Player &$playerA,Player &$playerB):void{
        $temps = $playerA;
        $playerA = $playerB;
        $playerB = $temps;
    }

    /**
    * @public méthode permettant de retourner le paramètre injectable playerA
    * @return Player
    */
    public function getterplayerA():Player{
        return $this->playerA;
    }
    
    /**
    * @public méthode permettant de retourner le paramètre injectable playerB
    * @return Player
    */
    public function getterplayerB():Player{
        return $this->playerB;
    }
}
