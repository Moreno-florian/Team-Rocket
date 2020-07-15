<?php

/*********************************************************** DAO **************************************************************/
require_once 'Dao/daoStat.php'; // To call DaoStat class code.

class ControllerStat
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runStatProcessing(): void
    {
        switch (key($_GET)) {
                /************************************** Stats list ***************************************/
            case 'statList':
                if ((isset($_SESSION['Role']) and isset($_SESSION['PlayerID'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur" or $_SESSION['Role'] == "Utilisateur")) { // If the user is "Administrateur" or "Modérateur" or "Utilisateur"


                    if (isset($_POST['Season'])) {
                        $list = (new DaoStat())->showGoal($_POST['Season']);    // Call function showGoal() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $goal = $stat['total buts'];
                        }

                        $list = (new DaoStat())->showPass($_POST['Season']);    // Call function showPass() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $pass = $stat['total passes'];
                        }

                        $list = (new DaoStat())->showTime($_POST['Season']);    // Call function showTime() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $time = ($stat['total temps de jeu'] / 100) / 60;   // To convert total time in hours.
                        }

                        $list = (new DaoStat())->showPresence($_POST['Season']);    // Call function showPresence() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $presence = $stat['presence'];
                        }
                    } else {

                        $list = (new DaoStat())->showGoal(date("Y") . "/" . (date("Y") + 1));    // Call function showGoal() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $goal = $stat['total buts'];
                        }

                        $list = (new DaoStat())->showPass(date("Y") . "/" . (date("Y") + 1));    // Call function showPass() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $pass = $stat['total passes'];
                        }

                        $list = (new DaoStat())->showTime(date("Y") . "/" . (date("Y") + 1));    // Call function showTime() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $time = ($stat['total temps de jeu'] / 100) / 60; // To convert total time in hours.

                        }

                        $list = (new DaoStat())->showPresence(date("Y") . "/" . (date("Y") + 1));    // Call function showPresence() from "Dao/daoStat.php"
                        foreach ($list as $stat) {
                            $presence = $stat['presence'];
                        }
                    }
                    
                    if (!isset($presence)) {
                        $presence = 0;
                    }
                    if (!isset($time)) {
                        $time = 0;
                    }
                    if (!isset($pass)) {
                        $pass = 0;
                    }
                    if (!isset($pass)) {
                        $pass = 0;
                    }
                    if (!isset($goal)) {
                        $goal = 0;
                    }

                    include_once "./View/Play/statList.phtml";       // Go to page "view/Stadium/statList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;
            default:
                break;
        }
    }
}
