<?php

declare(strict_types=1);    // to impose "types" on variables and methods.

session_start();     // Begin session.

header('content-type: text/html; charset=utf-8');   // to get accents

require_once 'Dao/DBconnection.php';    // To call Dao class to connect to the dataBase

require_once 'Controller/controllerUserPlayer.php';     // To call controllerUserPlayer class
require_once 'Controller/controllerMatchPlay.php';  // To call controllerUserPlayer class
require_once 'Controller/controllerRivalTeam.php';  // To call controllerRivalTeam class
require_once 'Controller/controllerStadium.php';    //To call controllerStadium class.
require_once 'Controller/controllerPicture.php';    //To call controllerPicture class.
require_once 'Controller/controllerTop.php';    //To call controllerTopList class.
require_once 'Controller/controllerStat.php';    //To call controllerStat class.

(new ControllerUserPlayer())->runUserPlayerProcessing();   // Call function runUserPlayerProcessing() from "Controller/controllerUserPlayer.php"
(new ControllerStadium())->runStadiumProcessing();  // To call function runStadiumProcessing from Controller/controllerStadium.php
(new ControllerRivalTeam())->runRivalTeamProcessing();   // Call function runRivalTeamProcessing() from "Controller/controllerRivalTeam.php"
(new ControllerMatchPlay())->runControllerMatchPlayProcessing();   // Call function runControllerMatchPlayProcessing() from "Controller/controllerMatchPlay.php"
(new ControllerPicture())->runPictureProcessing();   // Call function runControllerMatchPlayProcessing() from "Controller/controllerMatchPlay.php"
(new ControllerTopList())->runControllerTopListProcessing();   // Call function runControllerTopListProcessing() from "Controller/controllerTop.php"
(new ControllerStat())->runStatProcessing();   // Call function runStatProcessing() from "Controller/ControllerStat.php"

if (empty($_GET) == true) {

    if (isset($_POST["Season"])) {

        if (isset($_SESSION['PlayerID'])) {
            $list = (new DaoPlay())->showPlayHomePage($_POST["Season"]);    // Call function showPlaySeason() from "Dao/daoPlay.php"
        } else {
            $list = (new DaoPlay())->showPlayHomePageNotUser($_POST["Season"]);    // Call function showPlaySeason() from "Dao/daoPlay.php"
        }
    } else {

        if (isset($_SESSION['PlayerID'])) {
            $list = (new DaoPlay())->showPlayHomePage(date("Y") . "/" . (date("Y") + 1));    // Call function showPlaySeason() from "Dao/daoPlay.php"
        } else {
            $list = (new DaoPlay())->showPlayHomePageNotUser(date("Y") . "/" . (date("Y") + 1));    // Call function showPlaySeason() from "Dao/daoPlay.php"
        }
    }
    
    include_once 'View/Play/homePage.phtml';  // to go on homePage
}
