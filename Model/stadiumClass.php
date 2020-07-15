<?php

class Stadium
{
    private $_idStadium;
    private $_name;
    private $_adress;
    private $_groundType;
    private $_commentary;

    public function __construct($idStadium, $name, $adress, $groundType, $commentary)
    {
        $this->_idStadium = $idStadium;
        $this->_name = $name;
        $this->_adress = $adress;
        $this->_groundType = $groundType;
        $this->_commentary = $commentary;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idStadium()
    {
        return $this->_idStadium;
    }

    public function get_name()
    {
        return $this->_name;
    }

    public function get_adress()
    {
        return $this->_adress;
    }

    public function get_groundType()
    {
        return $this->_groundType;
    }

    public function get_commentary()
    {
        return $this->_commentary;
    }

    /****************************************************************************************************************************/
}
