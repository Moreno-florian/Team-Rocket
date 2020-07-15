<?php

class Player
{
    private $_idPlayer;
    private $_lastname;
    private $_firstname;
    private $_arrivalYear;
    private $_position;
    private $_picture;
    private $_licenseNumber;
    private $_idUser;

    public function __construct($idPlayer, $lastname, $firstname, $arrivalYear, $position, $picture, $licenseNumber, $idUser)
    {
        $this->_idPlayer = $idPlayer;
        $this->_lastname = $lastname;
        $this->_firstname = $firstname;
        $this->_arrivalYear = $arrivalYear;
        $this->_position = $position;
        $this->_picture = $picture;
        $this->_licenseNumber = $licenseNumber;
        $this->_idUser = $idUser;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idPlayer()
    {
        return $this->_idPlayer;
    }

    public function get_lastname()
    {
        return $this->_lastname;
    }

    public function get_firstname()
    {
        return $this->_firstname;
    }

    public function get_arrivalYear()
    {
        return $this->_arrivalYear;
    }

    public function get_position()
    {
        return $this->_position;
    }

    public function get_picture()
    {
        return $this->_picture;
    }

    public function get_licenseNumber()
    {
        return $this->_licenseNumber;
    }

    public function get_idUser()
    {
        return $this->_idUser;
    }

    /****************************************************************************************************************************/
}
