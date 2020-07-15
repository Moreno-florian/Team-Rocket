<?php

class Play
{
    private $_idPlayer;
    private $_idMatch;
    private $_idRivalTeam;
    private $_goalByMatch;
    private $_assist;
    private $_position;
    private $_playTimeByMatch;

    public function __construct($idPlayer, $idMatch, $idRivalTeam, $goalByMatch, $assist, $position,$playTimeByMatch)
    {
        $this->_idPlayer = $idPlayer;
        $this->_idMatch = $idMatch;
        $this->_idRivalTeam = $idRivalTeam;
        $this->_goalByMatch = $goalByMatch;
        $this->_assist = $assist;
        $this->_position = $position;
        $this->_playTimeByMatch = $playTimeByMatch;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idPlayer()
    {
        return $this->_idPlayer;
    }

    public function get_idMatch()
    {
        return $this->_idMatch;
    }

    public function get_idRivalTeam()
    {
        return $this->_idRivalTeam;
    }

    public function get_goalByMatch()
    {
        return $this->_goalByMatch;
    }

    public function get_assist()
    {
        return $this->_assist;
    }

    public function get_position()
    {
        return $this->_position;
    }

    public function get_playTimeByMatch()
    {
        return $this->_playTimeByMatch;
    }
    
    /****************************************************************************************************************************/
}
