<?php

/********************************************************** Model *************************************************************/
require_once 'Model/stadiumClass.php'; // To call stadium class code.

/*********************************************************** DAO **************************************************************/
require_once 'Dao/daoStadium.php'; // To call DaoStadium class code.

class ControllerStadium
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runStadiumProcessing(): void
    {
        switch (key($_GET)) {
                /************************************** Stadium list ***************************************/
            case 'stadiumList':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $list = (new DaoStadium())->showStadiumList();    // Call function showStadiumList() from "Dao/daoStadium.php"

                    include_once "View/Stadium/stadiumList.phtml";       // Go to page "view/Stadium/stadiumList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /*********************************** Add stadium form ***************************************/
            case 'formAddStadium':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    include_once 'View/Stadium/formAddStadium.phtml';       // Go to page "view/Stadium/formAddStadium.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /*********************************** Add stadium code ***************************************/
            case 'addStadium':

                if (isset($_POST['Name'])) {

                    if (!empty($_POST["Name"]) and !empty($_POST["Adress"])) {  // If an important field is empty

                        $newStadium = new Stadium(null, addslashes(htmlspecialchars(ucfirst($_POST["Name"]))), addslashes(htmlspecialchars($_POST["Adress"])), addslashes(htmlspecialchars($_POST["TypeofTerrain"])), addslashes(htmlspecialchars($_POST["Commentary"])));    // New stadium object with parameters edited in a form from "view/Stadium/formAddStadium.phtml"

                        (new DaoStadium())->addStadium($newStadium);    // Call function addStadium() from "Dao/daoStadium.php"

                        header('Location: index.php?stadiumList');       // Go to page "view/Stadium/stadiumList.phtml"
                    } else {

                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formAddStadium');    // Go to page "view/Play/homePage"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /*********************************** Modify stadium form *************************************/
            case 'formModifyStadium':

                if (((isset($_POST['IdStadium']) or isset($_SESSION["saveId"])) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    if (isset($_POST["IdStadium"])) {
                        $idStadium = intval($_POST["IdStadium"]); // Transform id value from string to integer
                    } else {
                        $idStadium = intval($_SESSION["saveId"]); // Transform id value from string to integer, used if pseudo exist
                    }

                    $stadium = (new DaoStadium())->showOneStadium($idStadium);      // Call function showOneStadium() from 'Dao/daoStadium.php'

                    foreach ($stadium as $key) {
                        $key['Id_stade'];
                        $key['Nom_stade'];
                        $key['Adresse'];
                        $key['Type_de_terrain'];
                        $key['Commentaires'];
                    }

                    include_once "View/Stadium/formModifyStadium.phtml";       // Go to page "view/Stadium/formAddStadium.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /********************************* Modify stadium code ****************************************/
            case 'modifyStadium':

                if (isset($_POST['IdStadium'])) {

                    $idStadium = intval($_POST['IdStadium']);       // Transform id value from string to integer

                    $stadium = (new DaoStadium())->showOneStadium($idStadium);      // Call function showOneStadium() from 'Dao/daoStadium.php'

                    if (!empty($_POST["Name"]) and !empty($_POST["Adress"])) {  // If an important field is empty

                        $modStadium = new Stadium($idStadium, addslashes(htmlspecialchars(ucfirst($_POST["Name"]))), addslashes(htmlspecialchars($_POST["Adress"])), addslashes(htmlspecialchars($_POST["TypeofTerrain"])), addslashes(htmlspecialchars($_POST["Commentary"])));    // New stadium object with parameters edited in a form from "View/Stadium/formModifyStadium.phtml"

                        (new DaoStadium())->modifyStadium($modStadium);      // Call function modifyStadium() from 'Dao/daoStadium.php'

                        header('Location: index.php?stadiumList');       // Go to page "view/Stadium/stadiumList.phtml"

                    } else {

                        $_SESSION["saveId"] = $idStadium;  // Save ID for return to the form
                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formModifyStadium');    // Go to page "view/formModifyStadium.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /************************************ Delete stadium code *************************************/
            case 'deleteStadium':

                if ((isset($_POST['IdStadium']) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idStadium = intval($_POST['IdStadium']);       // Transform id value from string to integer

                    (new DaoStadium())->deleteStadium($idStadium);      // Call function deleteStadium() from 'Dao/daoStadium.php'

                    header('Location: index.php?stadiumList');       // Go to page "view/Stadium/stadiumList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

            default:
                break;
        }
    }
}
