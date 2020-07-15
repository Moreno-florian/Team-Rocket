<?php

/*********************************************************** DAO **************************************************************/
require_once 'Dao/daoTop.php';

class ControllerTopList
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runControllerTopListProcessing()
    {
        switch (key($_GET)) {
                /************************************** Top list ***************************************/
            case 'topList':

                if (isset($_POST['Season'])) {
                    $season = $_POST['Season'];    // Get season from post
                } else {
                    $season = date("Y") . "/" . (date("Y") + 1);    // Get the actual year for season
                }

                if (isset($_POST['TopList']) and $_POST['TopList'] == "TopAssist") {
                    $list = (new DaoTop())->showTopAssist($season);    // Call function showPlayList() from "Dao/daoPlay.php"
                } elseif (isset($_POST['TopList']) and $_POST['TopList'] == "TopTime") {
                    $list = (new DaoTop())->showTopTimeByMatch($season);    // Call function showPlayList() from "Dao/daoPlay.php"
                } elseif (isset($_POST['TopList']) and $_POST['TopList'] == "TopPresence") {
                    $list = (new DaoTop())->showTopPresence($season);    // Call function showPlayList() from "Dao/daoPlay.php"
                } else {
                    $list = (new DaoTop())->showTopGoal($season);    // Call function showPlayList() from "Dao/daoPlay.php"
                }
                $ranking = 1;
                include_once 'View/Play/topList.phtml';    // Go to page "view/Match/matchList.phtml"
                break;
            default:
                break;
        }
    }
}
