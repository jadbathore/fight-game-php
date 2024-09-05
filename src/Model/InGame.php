<?php
namespace Model;

/**
* @class InGame permettant de gérer les événements "d'action du programme fight"
* je n'est pas effectuer de vérification dans cette partie du code étant donné que grâce au vérification précédament effectuer dans la class 
* abstractPlayer les données son considére formatter de la bonne manière si cela n'aurait pas été le cas cet class n'aurai jamais été appeler
*/
class InGame {

    /**
    * @public méthode génératrice : l'action est géré de façon à retourner un générateur grâce au mot clé yield la particularité est que une fois lancer
    * chaque itération représente 1 tour est à chaque tour impair les deux joueur on effectuer 1 round et donc 1 tour est généré 
    * @param array $playerA représente les informations du joueur 1 formatter à l'avance dans le constructeur de la class abstractPlayer
    * @param array $playerB représente les informations du joueur 2 formatter à l'avance dans le constructeur de la class abstractPlayer
    * @return Generator élément générateur grâce au mots clé yield qui vas génère plusieur sortie (méthode utilisable dans un loop)
    */
    public function round(array $playerA,array $playerB):\Generator
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

            $this->playerSorting($playerA,$playerB);
            $this->playerTurn($playerA,$playerB);
            /*
                par la suite vérification du playerA uniquement étant donné que ce sera toujours cette variable qui recevra les dégâts je n'est pas besoin
                de vérifier playerB car il restera le même durant cette boucle et il à été vérifié au paravent durant la précédente itération sous le
                nom de playerA
            */
            if($playerA['pv'] <= 0){
                break 1;
            }
            //ici a chaque nombre impair de l'itération on retourne yield étant donné que a chaque nombre impair les deux joueur on effectuer leur tour
            ($i%2 == 1)? '' :yield $playerA['pv']." ".$playerB['pv'];
        }
            // une fois sortie du while on décide le vainqueur grâce à cette formule (celui qui n'est pas à 0 ou moins)
            $winner = ($playerA['pv'] <= 0)? $playerB: $playerA;
            // puis on génère une dernière fois le code
            yield $winner['name']." ".$winner['pv'];
    }

    /**
    * @public méthode permettant de modifier de manière 'permanente' les données de l'arrayDef (en accord avec la formule demander par l'exercice
    * pv_j1 = pv_j1 - (attaque_j2 - def_j1))
    * @param array &$playerDef le joueur représentant la défense (le prefix & est utilisé pour mondifier de manière constante les données)
    * @param array $playerAtt le joueur représentant l’attaquant (le prefix & n'est pas vraiment utile dans ce contexte étant donné que
    * l'on n'a pas besoin de changer les données de l'attaquant et si elle doivent etre changer une autre méthode peut s'en occuper)
    * @return void (effectué juste le changement pas besoin de retourner quelque chose)
    */
    public function playerTurn(array &$playerDef,array $playerAtt):void {
        $playerDef['pv'] = $playerDef['pv'] - ($playerAtt['att'] - $playerDef['def']);
    }

    /**
    * @public méthode permettant d'intervertir les données
    * @param array &$playerA représentant le premier array à intervertir (le prefix & utilisé puis intervertir de manière constante les données)
    * @param array &$player représentant le deuxième array à intervertir (le prefix & utilisé puis intervertir de manière constante les données)
    * @return void (effectué juste le changement pas besoin de retourner quelque chose)
    */

    public function playerSorting(array &$playerA,array &$playerB):void{
        $temps = $playerA;
        $playerA = $playerB;
        $playerB = $temps;
        }
    }

