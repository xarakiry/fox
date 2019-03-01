<?php
/**
 * Part of Localhost
 * User: xarakiry
 * Date: 3/1/19
 * Time: 3:20 PM
 */

class Team
{
    public $name;
    public $games;
    public $win;
    public $draw;
    public $defeat;
    public $scored;
    public $skiped;
    public $avgPerMatch;
    private $scale;

    /**
     * Team constructor.
     * @param $name
     * @param $games
     * @param $win
     * @param $draw
     * @param $defeat
     * @param $scored
     * @param $skiped
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->games = $data['games'];
        $this->win = $data['win'];
        $this->draw = $data['draw'];
        $this->defeat = $data['defeat'];
        $this->scored = $data['goals']['scored'];
        $this->skiped = $data['goals']['skiped'];
        $this->setAvgPerMatch();
    }

    public function getWinPercent()
    {
        return $this->percentCalculator($this->win);
    }

    public function getDrawPercent()
    {
        return $this->percentCalculator($this->draw);
    }

    private function percentCalculator($value)
    {
        return bcdiv(bcmul($value, 100, $this->scale), $this->games, $this->scale);
    }

    /**
     * Avg goals per match
     */
    public function setAvgPerMatch()
    {
        $this->avgPerMatch = bcdiv($this->scored, $this->games);
    }

    /**
     * Apx. attack count per match
     * @return string
     */
    public function getAttackPerMatch()
    {
        return bcmul($this->avgPerMatch, 3);
    }

    public function getDefenseFactor()
    {
        return bcmul(bcdiv($this->skiped, $this->scored, 1), 10);
    }

    public function getAttackFactor()
    {
        return bcmul(bcdiv($this->scored, $this->skiped, 1), 10);
    }

    public function defenseMotivation()
    {
        $attackFactor = $this->getAttackFactor();
        $bonus = bcdiv(bcadd($attackFactor, $this->getWinPercent()+100), 100);
        return bcadd($attackFactor, $bonus);
    }

    public function wishToWin($winPercent)
    {
        return mt_rand(0, 100) > $winPercent ? false : true;
    }
}