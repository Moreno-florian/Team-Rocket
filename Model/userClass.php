<?php

class User
{
    private $_idUser;
    private $_pseudo;
    private $_password;
    private $_mail;
    private $_role;

    public function __construct($idUser, $pseudo, $password, $mail, $role)
    {
        $this->_idUser = $idUser;
        $this->_pseudo = $pseudo;
        $this->_password = $password;
        $this->_mail = $mail;
        $this->_role = $role;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idUser()
    {
        return $this->_idUser;
    }

    public function get_pseudo()
    {
        return $this->_pseudo;
    }

    public function get_password()
    {
        return $this->_password;
    }

    public function get_mail()
    {
        return $this->_mail;
    }

    public function get_role()
    {
        return $this->_role;
    }

    /****************************************************************************************************************************/
}
