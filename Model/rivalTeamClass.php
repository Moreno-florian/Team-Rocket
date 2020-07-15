<?php

class Rivalteam
{
    private $_idRivalTeam;
    private $_nameRivalTeam;

    public function __construct($idRivalTeam, $nameRivalTeam)
    {
        $this->_idRivalTeam = $idRivalTeam;
        $this->_nameRivalTeam = $nameRivalTeam;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idRivalTeam()
    {
        return $this->_idRivalTeam;
    }

    public function get_nameRivalTeam()
    {
        return $this->_nameRivalTeam;
    }

    /*************************************************************************************************************************/
}
