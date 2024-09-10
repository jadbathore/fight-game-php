<?php

namespace model;

/**
 * @class model object player permettant de formatter les methode du joueur
 * @construct grace a un $array = [
 * - 'name' => string
 * - 'pv' => int|string convetible en int
 * - 'att' => int|string convetible en int
 * - 'def' => int|string convetible en int
 * - ]  
 * 
 */
class Player
{
    private string $name;
    private int|string $health;
    private int|string $attack;
    private int|string $defense;

    public function __construct(
        array $array)
    {
        $this->name = $array['name'];
        $this->health = (int) $array['pv'];
        $this->attack = (int) $array['att'];
        $this->defense = (int) $array['def'];
    }
    public function takeDamage(int $damage):void
    {
        $this->health -= max(0, $damage - $this->defense);
    }

    /**
     * @return bool si le joueur est en vie
     */
    public function isAlive():bool
    {
        return $this->health > 0;
    }
    /**
     * @return bool si le joueur est mort 
     */
    public function isDead():bool
    {
        return $this->health <= 0;
    }

    /**
     * @return int la santer
     */
    public function getHealth():int
    {
        return $this->health;
    }

    /**
     * @return string le nom du joueur 
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param Player $opponent represent l'opposant qu va recevoir les dégat 
     */
    public function attack(Player $opponent):void
    {
        $opponent->takeDamage($this->attack);
    }
}