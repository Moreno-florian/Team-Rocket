<?php

/*********************************************************** Model **************************************************************/
require_once 'Model/playerClass.php'; // To call player class code.
require_once 'Model/userClass.php'; // To call user class code.
require_once 'Model/playClass.php'; // To call play class code.

/*********************************************************** DAO ****************************************************************/
require_once 'Dao/daoPlayer.php'; // To call DaoPlayer class code.
require_once 'Dao/daoUser.php'; // To call DaoUser class code.
require_once 'Dao/daoPlay.php'; // To call DaoPlay class code.


class ControllerUserPlayer
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runUserPlayerProcessing(): void
    {
        switch (key($_GET)) {
                /************************************** Team page ***************************************/
            case 'team':

                $list = (new DaoUser())->showUserList();    // Call function showUserList() from "Dao/daoUser.php"

                include_once "view/UserPlayer/teamPage.phtml";    // Go to page "view/UserPlayer/teamPage.phtml"
                break;

                /************************************** Users list ***************************************/
            case 'userList':

                if (isset($_SESSION["Role"]) and ($_SESSION["Role"] == "Administrateur" or $_SESSION["Role"] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $list = (new DaoUser())->showUserList();    // Call function showUserList() from "Dao/daoUser.php"

                    include_once "view/UserPlayer/userList.phtml";    // Go to page "view/UserPlayer/userList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /*********************************** Add user form ***************************************/
            case 'createAccount':

                include_once "view/UserPlayer/formCreateAccount.phtml";    // Go to page "view/UserPlayer/formCreateAccount.phtml"
                break;

                /*********************************** Add user code ***************************************/
            case 'addUser':

                if (isset($_POST["PseudoUser"])) {

                    if (!empty($_POST["PseudoUser"]) and !empty($_POST["Lastname"]) and !empty($_POST["Firstname"]) and !empty($_POST["PasswordValid"]) and !empty($_POST["Mail"])) {  // If an important field is not empty

                        $valid = (new DaoUser())->checkPseudoAvailable(addslashes(htmlspecialchars($_POST["PseudoUser"])));   // Check if a pseudo exist

                        if ($valid == true) {

                            $newUser = new User(null, addslashes(htmlspecialchars($_POST["PseudoUser"])), addslashes(htmlspecialchars($_POST["PasswordValid"])), addslashes(htmlspecialchars($_POST["Mail"])), "Utilisateur");    // New user object with parameters edited in a form from "view/UserPlayer/formAddUser.phtml"
                            $newidUser = (new DaoUser())->addUser($newUser);    // Call function addUser() from "Dao/daoUser.php and give the new User ID to a variable"

                            $profilePitureLink = (new DaoPlayer())->addPictureProfile($_FILES["Picture"]);    // Call function addUser() from "Dao/daoPlayer.php and give its link"
                            $newPlayer = new Player(null, addslashes(htmlspecialchars(ucfirst($_POST["Lastname"]))), addslashes(htmlspecialchars(ucfirst($_POST["Firstname"]))), addslashes(htmlspecialchars(ucfirst($_POST["ArrivalYear"]))), addslashes(htmlspecialchars($_POST["Position"])), $profilePitureLink, addslashes(htmlspecialchars($_POST["LicenseNumber"])), $newidUser);  // New player object with parameters edited in a form from "view/UserPlayer/formAddUser.phtml and idUser for the foreign key"
                            (new DaoPlayer())->addPlayer($newPlayer);   // Call function addPlayer() from "Dao/daoPlayer.php"

                            header('Location: index.php?userList');    // Go to page "view/UserPlayer/userList.phtml"
                        } else {

                            $_SESSION["error"] = "Pseudo déjà utilisé";    // Create an error message
                            header('Location: index.php?createAccount');    // Go to page "view/UserPlayer/formCreateAccount.phtml"
                        }
                    } else {

                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?createAccount');    // Go to page "view/UserPlayer/formCreateAccount.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /********************************** Modify account form ************************************/
            case 'modifyAccount':

                if (isset($_POST["userId"]) or isset($_SESSION["saveId"])) {

                    if (isset($_POST["userId"])) {
                        $idUser = intval($_POST["userId"]); // Transform id value from string to integer, used if pseudo exist
                    } else {
                        $idUser = intval($_SESSION["saveId"]); // Transform id value from string to integer
                    }

                    $user = (new DaoUser())->showOneUser($idUser);    // Call function showOneUser() from "Dao/daoUser.php"

                    foreach ($user as $key) {
                        $key['Id_utilisateur'];
                        $key['Id_joueur'];
                        $key['Photo'];
                        $key['Pseudo'];
                        $key['Nom'];
                        $key['Prenom'];
                        $key['Mail'];
                        $key['Password'];
                        $key['Role'];
                        $key['Poste_principal'];
                        $key['Numero_de_licence'];
                        $key['Annee_d_arrivee'];
                    }

                    include_once "view/UserPlayer/formModifyAccount.phtml";     // Go to page "view/UserPlayer/formModifyAccount.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /************************************* Modify user code *************************************/
            case 'modifyUser':

                if (isset($_POST["userId"])) {

                    $idUser = intval($_POST["userId"]); // Transform id value from string to integer;
                    $idPlayer = intval($_POST["playerId"]); // Transform id value from string to integer

                    $user = (new DaoUser())->showOneUser($idUser);    // Call function showUser() from "Dao/daoUser.php"

                    foreach ($user as $key) {
                        $key['Pseudo'];       // Get the old Pseudo from database
                        $key['Role'];       // Get the old role from database
                    }

                    if (!empty($_POST["PseudoUser"]) and !empty($_POST["Lastname"]) and !empty($_POST["Firstname"]) and !empty($_POST["PasswordValid"]) and !empty($_POST["Mail"])) {  // If an important field is not empty

                        $valid = (new DaoUser())->checkPseudoAvailable(addslashes(htmlspecialchars($_POST["PseudoUser"])));   // Check if a pseudo exist

                        if ($valid == true or addslashes(htmlspecialchars($_POST["PseudoUser"])) == $key['Pseudo']) {   // if a pseudo does not exist

                            if (!isset($_POST["Role"])) {
                                $userRole = $key['Role'];       // If new role does not exist give the old 
                            } else {
                                $userRole = addslashes(htmlspecialchars($_POST["Role"]));
                            }

                            $modUser = new User($idUser, addslashes(htmlspecialchars($_POST["PseudoUser"])), addslashes(htmlspecialchars($_POST["PasswordValid"])), addslashes(htmlspecialchars($_POST["Mail"])), $userRole);    // New user object with parameters edited in a form from "view/UserPlayer/formModifyAccount.phtml"

                            (new DaoUser())->modifyUser($modUser);    // Call function modifyUser() from "Dao/daoUser.php"

                            $profilePitureLink = (new DaoPlayer())->modifyPictureProfile($_FILES["Picture"], $_POST["oldPicture"]);    // Call function modifyPictureProfile() from "Dao/daoPlayer.php"
                            $modPlayer = new Player($idPlayer, addslashes(htmlspecialchars(ucfirst($_POST["Lastname"]))), addslashes(htmlspecialchars(ucfirst($_POST["Firstname"]))), addslashes(htmlspecialchars(ucfirst($_POST["ArrivalYear"]))), addslashes(htmlspecialchars($_POST["Position"])), $profilePitureLink, intval(addslashes(htmlspecialchars($_POST["LicenseNumber"]))), $idUser);  // New player object with parameters edited in a form from "view/UserPlayer/formAddUser.phtml and idUser for the foreign key"

                            (new DaoPlayer())->modifyPlayer($modPlayer);   // Call function modifyPlayer() from "Dao/daoPlayer.php"

                            if ($idUser == $_SESSION["UserID"]) {
                                $_SESSION["Picture"]        = $profilePitureLink;
                                $_SESSION["Pseudo"]         = addslashes(htmlspecialchars($_POST["PseudoUser"]));
                                $_SESSION["LastName"]       = addslashes(htmlspecialchars(ucfirst($_POST["Lastname"])));
                                $_SESSION["FirstName"]      = addslashes(htmlspecialchars(ucfirst($_POST["Firstname"])));
                                $_SESSION["Role"]           = $userRole;
                                $_SESSION["Position"]       = addslashes(htmlspecialchars($_POST["Position"]));
                            }

                            header('Location: index.php?userList');  // Go to page "view/UserPlayer/userList.phtml"
                        } else {

                            $_SESSION["saveId"] = $idUser;  // Save ID for return to the form
                            $_SESSION["error"] = "Pseudo déjà utilisé";  // Create an error message
                            header('Location: index.php?modifyAccount');  // Go to page "view/UserPlayer/formModifyAccount.phtml"
                        }
                    } else {

                        $_SESSION["saveId"] = $idUser;  // Save ID for return to the form
                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?modifyAccount');    // Go to page "view/UserPlayer/formCreateAccount.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /*********************** Delete user code, !! only for administrator !!  ***********************/
            case 'removeUser':

                if ((isset($_POST["userId"]) and isset($_SESSION["Role"])) and ($_SESSION["Role"] == "Administrateur" or $_SESSION["Role"] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idUser = intval($_POST["userId"]);     // Transform id value from string to integer
                    $idPlayer = intval($_POST["playerId"]);    // Transform id value from string to integer

                    $profilePitureLink = (new DaoPlayer())->deletePictureProfile($_POST["Picture"]);   // Call function deletePictureProfile() from "Dao/daoPlayer.php"

                    (new DaoPlayer())->deletePlayer($idPlayer);   // Call function deletePlayer() from "Dao/daoPlayer.php"
                    (new DaoPlay())->deletePlayPlayer($idPlayer);   // Call function deletePlayPlayer() from "Dao/daoPlay.php"
                    (new DaoUser())->deleteUser($idUser);   // Call function deleteUser() from "Dao/daoUser.php"

                    header('Location: index.php?userList'); // Go to page "view/UserPlayer/userList.php"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                break;

                /******************************* Account connection code ***********************************/
            case 'accountConnection':

                if (isset($_POST["Pseudo"]) and isset($_POST["Password"])) {

                    $userConnection = (new DaoUser())->connectionAccount(addslashes(htmlspecialchars($_POST["Pseudo"])));    // Call function connectionAccount() from "Dao/daoUser.php"

                    if (empty($userConnection)) {
                        $_SESSION["error"] = "Pseudo inconnu";      // Create an error message;
                        header('Location: index.php');    // Go to page "view/Play/homePage"
                    } else {

                        foreach ($userConnection as $keyVerify) {
                            $keyVerify['Password'];     // To get password from database
                        }

                        $passwordCheck = password_verify($_POST["Password"], $keyVerify['Password']);   // Check that a password matches a hash

                        if ($passwordCheck == true) {

                            foreach ($userConnection as $key) {
                                $_SESSION["UserID"]         = $key['Id_utilisateur'];
                                $_SESSION["PlayerID"]       = $key['Id_joueur'];
                                $_SESSION["Picture"]        = $key['Photo'];
                                $_SESSION["Pseudo"]         = $key['Pseudo'];
                                $_SESSION["LastName"]       = $key['Nom'];
                                $_SESSION["FirstName"]      = $key['Prenom'];
                                $_SESSION["Role"]           = $key['Role'];
                                $_SESSION["Position"]       = $key['Poste_principal'];
                            }

                            header('Location: index.php'); // Go to page "view/homePage.php"
                        } else {

                            $_SESSION["error"] = "Mot de passe incorect";      // Create an error message;
                            header('Location: index.php'); // Go to page "view/homePage.php"
                        }
                    }

                    header('Location: index.php'); // Go to page "view/homePage.php"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage"
                }
                var_dump($passwordCheck);
                break;

                /********************************* Account logout code **************************************/
            case 'accountLogout':

                session_unset();
                session_destroy();

                header('Location: index.php');    // Go to page "view/Play/homePage"
                break;

            default:
                break;
        }
    }
}
