<?php

class Match
{
    private $_idMatch;
    private $_hours;
    private $_date;
    private $_season;
    private $_idStadium;

    public function __construct($idMatch, $hours, $date, $season, $idStadium)
    {
        $this->_idMatch = $idMatch;
        $this->_hours = $hours;
        $this->_date = $date;
        $this->_season = $season;
        $this->_idStadium = $idStadium;
    }

    /**************************** ACCESSEURS ********************************/

    public function get_idMatch()
    {
        return $this->_idMatch;
    }

    public function get_hours()
    {
        return $this->_hours;
    }

    public function get_date()
    {
        return $this->_date;
    }

    public function get_season()
    {
        return $this->_season;
    }

    public function get_idStadium()
    {
        return $this->_idStadium;
    }  
}
