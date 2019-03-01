<?php
/**
 * Part of Localhost
 * User: xarakiry
 * Date: 3/1/19
 * Time: 3:53 PM
 */
include 'Team.php';

class Engine
{
    public $data;

    /**
     * Engine constructor.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * change
     * @param $probability
     * @return int
     */
    private function getAttackResult($attackFactor, $defenseFactor)
    {
        return mt_rand(0, $attackFactor) > mt_rand(0, $defenseFactor) ? 1 : 0;
    }

    /**
     * Run point
     * @param int $firstTeamIdx
     * @param int $secondTeamIdx
     * @return array
     */
    public function getScore(int $firstTeamIdx, int $secondTeamIdx)
    {
        $firstTeam = new Team($this->data[$firstTeamIdx]);
        $secondTeam = new Team($this->data[$secondTeamIdx]);
        return $this->attack($firstTeam, $secondTeam);
    }

    /**
     * Making attack
     * @param Team $firstTeam
     * @param Team $secondTeam
     * @return array
     */
    private function attack(Team $firstTeam, Team $secondTeam)
    {
        $team1Goals = $this->firstTeamGoals($firstTeam, $secondTeam);
        $team2Goals = $this->secondTeamGoals($firstTeam, $secondTeam);
        return [$team1Goals, $team2Goals];
    }

    /**
     * Attack simulator for first team
     * @param Team $first
     * @param Team $second
     * @return int
     */
    private function firstTeamGoals(Team $first, Team $second)
    {
        $goals = 0;
        for ($i = 1; $i <= $first->getAttackPerMatch(); $i++) {
            $secondTeamDefense = $second->getDefenseFactor();
            if ($second->wishToWin($second->getWinPercent())) {
                $secondTeamDefense = $second->defenseMotivation();
            }
            $goals += $this->getAttackResult($first->getAttackFactor(), $secondTeamDefense);
        }
        return $goals;
    }

    /**
     * Attack simulator for second team
     * @param Team $first
     * @param Team $second
     * @return int
     */
    private function secondTeamGoals(Team $first, Team $second)
    {
        $goals = 0;
        for ($i = 1; $i <= $second->getAttackPerMatch(); $i++) {
            $firstTeamdefense = $first->getDefenseFactor();
            if ($first->wishToWin($first->getWinPercent())) {
                $firstTeamdefense = $first->defenseMotivation();
            }
            $goals += $this->getAttackResult($second->getAttackFactor(), $firstTeamdefense);
        }
        return $goals;
    }
}

