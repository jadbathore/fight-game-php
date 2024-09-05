<?php
namespace Controller;

use Model\AbstractPlayer;
use Model\ErrorsFightGame;
use Model\InGame;

/*
test : php bin/kahlan
etude de cas recrutement: php-fight-game
le projet est divisé en 2 partie model Controller (pas de view parce que c'est en test donc les sorties son console)
PS/ je me suis permis de modifier légèrement de fichier : ./spec/GameSpec.php pour permettre l'usage du namespace Controller;

 */

/**
* @namespace Controller
* @extends AbstractPlayer etant donné que c'est en model veiw controller j'ai effectué une classe abstraite permettant d'injecter les paramètres private
* playerA et playerB de manière abstraite pour ne pas les ecrires en dure dans le controller Comme cela le model s'occupe de la construction des prefefini AbstractPlayer
* en injectant sa logique
* @class Game class permettant d'effectuer la fonction de controller qui va actionner controller l'action décidé par les models
* @construct ce construit a partir du parent AbstractPlayer qui lui même et parent de ErrorFightGame
* @param string $input permettant de donner les joueurs
 */
class Game extends AbstractPlayer
{
    public function __construct(
        string $input,
        )
    {
        parent::__construct($input);
    }

    /**
    * @public fonction permettant d'actionner le test
    * @return void
    * @throw Exeception() exception levée si parent::$error (de la class ErrorFightGame) n'est pas vide sinon l'erreur s'affiche en rouge exemple
    * disponible dans dossier img/

     */
    public function run()
    {
        try{
            if(!empty(parent::$error))
            {
                throw new \Exception(parent::$error);
            } else {
                $inGame = new InGame();
                //utilisation de la methode generatrice permettant de retourné le code
                $generator = $inGame->round($this->getterplayerA(),$this->getterplayerB());
                foreach($generator as $value) {
                    // utilisation de PHP_EOL sinon tout les données son transcrit en une seul ligne
                    print($value).PHP_EOL;
                }
            }
        } catch(\Exception $e) {
            echo "\e[1;37;41m"."error:". $e->getMessage()."\e[0m\n";
        }
        
    }
}