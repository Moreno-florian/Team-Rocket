<?php

class Picture
{
    private $_idPicture;
    private $_title;
    private $_urlPicture;
    
    public function __construct($idPicture,$title,$urlPicture)
    {
        $this->_idPicture=$idPicture;
        $this->_title=$title;
        $this->_urlPicture=$urlPicture;
    }

    /****************************************************** ACCESSEURS ******************************************************/

    public function get_idPicture()
    {
        return $this->_idPicture;
    }

    public function get_title()
    {
        return $this->_title;
    }
    public function get_urlPicture()
    {
        return $this->_urlPicture;
    }

    /****************************************************************************************************************************/
}

?>