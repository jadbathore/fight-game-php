<?php
namespace Controller;

use Exception;
use Model\AbstractParty;
use Model\SingleToneErrorsFightGame;
use Model\Player;

/*
test : php bin/kahlan
etude de cas recrutement: php-fight-game
le projet est divisé en 2 partie model Controller (pas de view parce que c'est en test donc les sorties son console)
PS/ je me suis permis de modifier légèrement de fichier : ./spec/GameSpec.php pour permettre l'usage du namespace Controller;

 */

/**
* @namespace Controller
* @extends AbstractParty etant donné que c'est en model veiw controller j'ai effectué une classe abstraite permettant d'injecter les paramètres private
* playerA et playerB de manière abstraite pour ne pas les ecrires en dure dans le controller Comme cela le model s'occupe de la construction des prefefini AbstractParty
* en injectant sa logique
* @class Game class permettant d'effectuer la fonction de controller qui va actionner controller l'action décidé par les models
* @construct ce construit à partir du parent AbstractParty 
* @param string $input permettant de donner les joueurs
 */
class Game extends AbstractParty
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
    * @throw Exeception() si la class singleTone est initialisé elle retourne l'erreur qui a été initialisé au paravent exemple et le ecrit de manière formater l'erreur dans le test
    * disponible dans dossier img/
     */
    public function run()
    {
        try{
            if(!SingleToneErrorsFightGame::isNotInit())
            {
                throw new Exception(SingleToneErrorsFightGame::getinitError());
            }
                $generator = $this->round($this->getterplayerA(),$this->getterplayerB());
                foreach($generator as $value) {
                    // utilisation de PHP_EOL sinon tout les données son transcrit en une seul ligne
                    print($value).PHP_EOL;
                }
        } catch(Exception $e) {
            echo "\e[1;37;41m"."error:". $e->getMessage()."\e[0m\n";
        }
    }
    /**
        * @public méthode génératrice : l'action est géré de façon à retourner un générateur grâce au mot clé yield la particularité est que une fois lancer
        * chaque itération représente 1 tour est à chaque tour impair les deux joueur on effectuer 1 round et donc 1 tour est généré 
        * @param Player $playerA représente les informations du joueur 1 formatter à l'avance dans le constructeur de la class abstractPlayer
        * @param Player $playerB représente les informations du joueur 2 formatter à l'avance dans le constructeur de la class abstractPlayer
        * @return Generator élément générateur grâce au mots clé yield qui vas génère plusieur sortie (méthode utilisable dans un loop)
        * @abstract round method abstrait que l'on est forcé de crée etant donné que cela fait partie des paramètres prédefini par le model AbstractParty
        */
        public function round(Player $playerA,Player $playerB):\Generator
        {
            $i = 0;
            while(++$i){
                /*
                    player sorting vas inverser les arrays de manière "constante" comme cela à chaque tour:
                    - playerA représentera le défenseur (celui qui reçoit les dégâts)
                    - playerB représentera l'attaquant(celui qui inflige les dégâts)
                    donc la boucle effectue premier tour $playerA = 'Bob' qui va recevoir les dégâts puis deuxième tour $playerA ='alice' et recevra les dégâts
                    puis par la suite on gènere le résultat
               */
                $this->swapPlayer($playerA,$playerB);
                $playerB->attack($playerA);
                if($playerA->isDead()){
                    break 1;
                }
                $shouldSendResult = ($i%2 == 1);
                $shouldSendResult ? '' :yield $playerA->getHealth()." ".$playerB->getHealth();
            }
                // une fois sortie du while on décide le vainqueur grâce à cette formule (celui qui n'est pas à 0 ou moins)
                $winner = ($playerA->isAlive())? $playerA: $playerB;
                // puis on génère une dernière fois le code
                yield $winner->getName()." ".$winner->getHealth();
        }
}