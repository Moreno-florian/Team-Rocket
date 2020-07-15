<?php

/********************************************************** Model *************************************************************/
require_once 'Model/rivalTeamClass.php';// To call rivalTeam class code.
require_once 'Model/playClass.php'; // To call play class code.

/*********************************************************** DAO **************************************************************/
require_once 'Dao/daoRivalTeam.php';// To call DaoRivalTeam class code.
require_once 'Dao/daoPlay.php'; // To call DaoPlay class code.

class ControllerRivalTeam
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runRivalTeamProcessing(): void
    {
        switch (key($_GET)) {
                /************************************* RivalTeam list *************************************/
            case 'rivalTeamList':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $list = (new DaoRivalTeam())->showRivalteamList();    // Call function showRivalteamList() from "Dao/daoRivalTeam.php"

                    include_once "View/RivalTeam/rivalTeamList.phtml";    // Go to page "view/RivalTeam/rivalTeamList.phtml"            
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Add rivalTeam form ***********************************/
            case 'formAddRivalTeam':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    include_once "view/RivalTeam/formAddRivalTeam.phtml";    // Go to page "view/RivalTeam/formAddRivalTeam.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Add rivalTeam code ************************************/
            case 'addRivalTeam':

                if (isset($_POST['rivalTeamName'])) {

                    if (!empty($_POST["rivalTeamName"])) {

                        $newRivalTeam = new RivalTeam(null, addslashes(htmlspecialchars(ucfirst($_POST['rivalTeamName']))));    // Call function showUser() from "Dao/daoRivalTeam.php"

                        (new DaoRivalTeam())->addRivalTeam($newRivalTeam);      // Call function addRivalTeam() from "Dao/daoRivalTeam.php"

                        header('Location: index.php?rivalTeamList');    // Go to page "view/RivalTeam/rivalTeam.phtml"

                    } else {

                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formAddRivalTeam');    // Go to page "view/formAddRivalTeam.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Modify rivalTeam form *********************************/
            case 'formModifyRivalTeam':

                if (((isset($_POST['IdRivalTeam']) or isset($_SESSION["saveId"])) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    if (isset($_POST["IdRivalTeam"])) {
                        $idRivalTeam = intval($_POST['IdRivalTeam']);   // Transform id value from string to integer;
                    } else {
                        $idRivalTeam = intval($_SESSION["saveId"]); // Transform id value from string to integer, used if pseudo exist
                    }

                    $rivalTeam = (new DaoRivalTeam())->showOneRivalTeam($idRivalTeam);      // Call function showOneRivalTeam() from 'Dao/daoRivalTeam.php'

                    foreach ($rivalTeam as $key) {
                        $key['Id_equipe_adverse'];
                        $key['Nom_equipe'];
                    }

                    include_once "View/RivalTeam/formModifyRivalTeam.phtml";    // Go to page "view/RivalTeam/formModifyRivalTeam.phtml"
                } else {

                   header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /********************************* Modify rival team code *************************************/
            case 'modifyRivalTeam':

                if (isset($_POST['IdRivalTeam'])) {

                    $idRivalTeam = intval($_POST['IdRivalTeam']);   // Transform id value from string to integer;

                    $rivalTeam = (new DaoRivalTeam())->showOneRivalTeam($idRivalTeam);      // Call function showOneRivalTeam() from 'Dao/daoRivalTeam.php'

                    if (!empty($_POST["rivalTeamName"])) {  // If an important field is not empty

                        $modRivalTeam = new RivalTeam($idRivalTeam, addslashes(htmlspecialchars(ucfirst($_POST["rivalTeamName"]))));     // New RivalTeam object with parameters edited in a form from "view/Match/formModifyRivalTeam.phtml"

                        (new DaoRivalTeam())->modifyRivalTeam($modRivalTeam);      // Call function modifyRivalTeam() from 'Dao/daoRivalTeam.php'

                        header('Location: index.php?rivalTeamList');    // Go to page "view/RivalTeam/rivalTeam.phtml"

                    } else {
                        
                        $_SESSION["saveId"] = $idRivalTeam;  // Save ID for return to the form
                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formModifyRivalTeam');    // Go to page "view/formModifyStadium.phtml"

                    }
                } else {
                    
                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /************************************* Delete rival team ****************************************/
            case 'deleteRivalTeam':

                if ((isset($_POST['IdRivalTeam']) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idRivalTeam = intval($_POST['IdRivalTeam']);   // Transform id value from string to integer;

                    (new DaoPlay())->deletePlayPlayer($idRivalTeam);   // Call function deletePlayPlayer() from "Dao/daoPlay.php"
                    (new DaoRivalTeam())->deleteRivalTeam($idRivalTeam);      // Call function deleteRivalTeam() from 'Dao/daoRivalTeam.php'

                    header('location:index.php?rivalTeamList');    // Go to page "view/RivalTeam/rivalTeam.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

            default:
                break;
        }
    }
}
