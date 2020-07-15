<?php

/********************************************************** Model *************************************************************/
require_once 'Model/matchClass.php'; // To call match class code.
require_once 'Model/playClass.php'; // To call play class code.

/*********************************************************** DAO **************************************************************/
require_once 'Dao/daoMatch.php'; // To call DaoMatch class code.
require_once 'Dao/daoPlay.php'; // To call DaoPlay class code.
require_once 'Dao/daoRivalTeam.php'; // To call DaoRivalTeam class code.
require_once 'Dao/daoStadium.php'; // To call DaoStadium class code.

class ControllerMatchPlay
{
    /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
    public function runControllerMatchPlayProcessing()
    {
        switch (key($_GET)) {
                /************************************** Match list ***************************************/
            case 'matchList':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $list = (new DaoPlay())->showPlayList();    // Call function showPlayList() from "Dao/daoPlay.php"

                    include_once 'View/Match/matchList.phtml';    // Go to page "view/Match/matchList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Add match form ***************************************/
            case 'formAddmatch':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $rivalTeamList = (new DaoRivalTeam())->showRivalteamList();     // Show the Rival team list to asign on the imput type select
                    $stadiumList = (new DaoStadium())->showStadiumList();     // Show the stadium list to asign on the imput type select

                    include_once 'View/Match/formAddMatch.phtml';        // Go to page "view/Match/formAddMatch.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Add match code ***************************************/
            case 'addMatch':

                if (isset($_POST['Hours'])) {

                    if (!empty($_POST["Date"]) or !empty($_POST["Hours"])) { // To show if a field is empty

                        $newMatch = new Match(null, addslashes(htmlspecialchars($_POST["Hours"])), addslashes(htmlspecialchars($_POST["Date"])), addslashes(htmlspecialchars($_POST["Season"])), addslashes(htmlspecialchars($_POST["Stadium"])));   // New match object with parameters edited in a form from "view/Match/formAddMatch.phtml"
                        $newIdMatch = (new DaoMatch())->addMatch($newMatch);      // Call function addMatch() from "Dao/DaoMatch.php and give the new Match ID to a variable"

                        $newPlay = new Play($_SESSION["PlayerID"], $newIdMatch, addslashes(htmlspecialchars($_POST["Rivalteam"])), 0, 0, $_SESSION["Position"], 0);   // New Play object with parameters edited in a form from "view/Match/formAddMatch.phtml"
                        (new DaoPlay())->addPlay($newPlay);      // Call function addPlay() from "Dao/DaoPlay.php.

                        header('Location: index.php?matchList');     // Go to page "view/Match/matchList.phtml"

                    } else {

                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formAddmatch');    // Go to page "view/formAddMatch.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Modify match form *************************************/
            case 'formModifymatch':

                if (((isset($_POST['Idmatch']) or isset($_SESSION["saveId"])) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    if (isset($_POST['Idmatch'])) {
                        $idMatch = intval($_POST['Idmatch']);   // Transform id value from string to integer;
                    } else {
                        $idMatch = intval($_SESSION["saveId"]); // Transform id value from string to integer, used if pseudo exist
                    }

                    $matchList = (new DaoMatch())->showMatchList();     // Call function showMatchList() from "Dao/daoMatch.php"
                    $stadiumList = (new DaoStadium())->showStadiumList();     // Call function showStadiumList() from "Dao/daoStadium.php"
                    $rivalTeamList = (new DaoRivalTeam())->showRivalteamList();     // Call function showRivalteamList() from "Dao/daoRivalTeam.php"

                    $match = (new DaoPlay())->showOnePlay($idMatch);    // Call function showOnePlay() from "Dao/daoPlay.php"

                    foreach ($match as $key) {
                        $key['Id_joueur'];
                        $key['Nom'];
                        $key['Id_match'];
                        $key['Heure'];
                        $key['Date'];
                        $key['Saison'];
                        $key['Id_equipe_adverse'];
                        $key['Nom_equipe'];
                        $key['But_marque_par_match'];
                        $key['Passe_decisive_par_match'];
                        $key['Poste'];
                        $key['Temps_joue_par_match'];
                        $key['Id_stade'];
                        $key['Nom_stade'];
                    }

                    include_once 'View/Match/formModifyMatch.phtml';     // Go to page "view/Match/formModifyMatch.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Modify match code *************************************/
            case 'modifyMatch':

                if (isset($_POST['Match'])) {

                    $idMatch = intval($_POST['Match']);     // Transform id value from string to integer

                    if (!empty($_POST["Date"]) and !empty($_POST["Hours"])) {  // If an important field is not empty

                        $modMatch =  new Match(
                            $idMatch,
                            addslashes(htmlspecialchars($_POST["Hours"])),
                            addslashes(htmlspecialchars($_POST["Date"])),
                            addslashes(htmlspecialchars($_POST["Season"])),
                            addslashes(htmlspecialchars($_POST["Stadium"]))
                        );
                        // New Match object with parameters edited in a form from "view/Match/formModifyMatch.phtml"
                        (new DaoMatch())->modifyMatch($modMatch);    // Call function modifyMatch() from "Dao/daoMatch.php"

                        $modPlay = new Play($_SESSION["PlayerID"], $idMatch, addslashes(htmlspecialchars($_POST["Rivalteam"])), 0, 0, $_SESSION["Position"], 0); // New play object with parameters edited in a form from "view/Match/fomModifyMatch.phtml"    

                        (new DaoPlay())->modifyPlay($modPlay, $idMatch);    // Call function modifyPlay() from "Dao/daoPlay.php"

                        header('Location: index.php?matchList');     // Go to page "view/Match/matchList.phtml"

                    } else {

                        $_SESSION["saveId"] = $idMatch;  // Save ID for return to the form
                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formModifymatch');    // Go to page "view/formModifyStadium.phtml"

                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /********************************** Delete Match code ***************************************/
            case 'deletematch':

                if ((isset($_POST['Idmatch']) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idMatch = intval($_POST['Idmatch']);     // Transform id value from string to integer

                    (new DaoPlay())->deletePlayMatch($idMatch);   // Call function deletePlay() from "Dao/daoPlay.php"
                    (new DaoMatch())->deleteMatch($idMatch);   // Call function deleteMatch() from "Dao/daoMatch.php"

                    header('Location: index.php?matchList');     // Go to page "view/Match/matchList.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /************************************* Match registration *************************************/
            case 'matchRegistration':

                if ((isset($_SESSION['Role']) and isset($_POST['IdMatch']) and isset($_POST['IdPlayer']) and isset($_POST['IdRivalteam'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur" or $_SESSION['Role'] == "Utilisateur")) { // If the user is "Administrateur" or "Modérateur" and results of the form exist

                    $idPlayer = intval($_POST['IdPlayer']);     // Transform id value from string to integer
                    $idMatch = intval($_POST['IdMatch']);     // Transform id value from string to integer
                    $idRivalteam = intval($_POST['IdRivalteam']);     // Transform id value from string to integer

                    $newPlay = new Play($idPlayer, $idMatch, $idRivalteam, 0, 0, addslashes(htmlspecialchars($_POST['Position'])), 0);   // New Play object with parameters edited in a form from "view/Match/formAddMatch.phtml"
                    (new DaoPlay())->addPlay($newPlay);      // Call function addPlay() from "Dao/DaoPlay.php.

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /********************************** Player registration list ***********************************/
            case 'playerRegistration':

                if ((isset($_SESSION['Role']) and (isset($_POST['Idmatch']) or isset($_SESSION['IdMatch']))) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur" and results of the form exist

                    if (isset($_POST['Idmatch'])) {
                        $idMatch = intval($_POST['Idmatch']);     // Transform id value from string to integer
                    } else {
                        $idMatch = intval($_SESSION['IdMatch']);     // Transform id value from string to integer
                        $_SESSION['IdMatch'] = null;
                    }

                    $list = (new DaoPlay())->showOnePlay($idMatch);   // Call function showOnePlay() from "Dao/daoPlay.php"

                    foreach ($list as $player) {
                    }

                    include_once 'View/Play/playerOnMatch.phtml';     // Go to page "view/Match/playerOnMatch.phtml"

                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /******************************** Player modify registration form *********************************/
            case 'playerModifyRegistrationForm':

                if ((isset($_SESSION['Role']) and isset($_POST['IdMatch'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur" and results of the form exist

                    $_SESSION['IdMatch'] = intval($_POST['IdMatch']);     // Transform id value from string to integer ang give on session variable

                    $idPlayer = intval($_POST['IdPlayer']);     // Transform id value from string to integer
                    $idMatch = intval($_POST['IdMatch']);     // Transform id value from string to integer
                    $idRivalteam = intval($_POST['IdRivalteam'],);     // Transform id value from string to integer

                    $play = (new DaoPlay())->showOnePlayerRegistration($idPlayer, $idMatch);    // Call function showPlayerRegistration() from "Dao/daoPlay.php"

                    foreach ($play as $line) {
                        $line['Id_joueur'];
                        $line['Id_match'];
                        $line['Id_equipe_adverse'];
                        $line['But_marque_par_match'];
                        $line['Passe_decisive_par_match'];
                        $line['Poste'];
                        $line['Temps_joue_par_match'];
                    }

                    include_once 'View/Play/formModifyPlay.phtml';     // Go to page "view/Match/playerOnMatch.phtml"

                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /******************************** Player modify registration code *********************************/
            case 'playerModifyRegistration':

                if ((isset($_SESSION['Role']) and isset($_POST['Idmatch'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur" and results of the form exist

                    $_SESSION['IdMatch'] = intval($_POST['IdMatch']);     // Transform id value from string to integer ang give on session variable

                    $idPlayer = intval($_POST['IdPlayer']);     // Transform id value from string to integer
                    $idMatch = intval($_POST['IdMatch']);     // Transform id value from string to integer
                    $idRivalteam = intval($_POST['IdRivalteam'],);     // Transform id value from string to integer

                    $modPlay =  new Play($idPlayer, $idMatch, $idRivalteam, addslashes(htmlspecialchars($_POST["Goal"])), addslashes(htmlspecialchars($_POST["Assist"])), addslashes(htmlspecialchars($_POST["Position"])), addslashes(htmlspecialchars($_POST["PlayTime"]))); // New Play object with parameters edited in a form from "view/Play/formModifyPlay.phtml"

                    (new DaoPlay())->modifyPlayerRegistration($modPlay);
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /************************************** Match unsubscribe **************************************/
            case 'matchUnsubscribe':

                if ((isset($_SESSION['Role']) and isset($_POST['IdMatch']) and isset($_POST['IdPlayer']) and isset($_POST['IdRivalteam'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur" or $_SESSION['Role'] == "Utilisateur")) { // If the user is "Administrateur" or "Modérateur" and results of the form exist

                    $_SESSION['IdMatch'] = intval($_POST['IdMatch']);     // Transform id value from string to integer ang give on session variable

                    $idPlayer = intval($_POST['IdPlayer']);     // Transform id value from string to integer
                    $idMatch = intval($_POST['IdMatch']);     // Transform id value from string to integer
                    $idRivalteam = intval($_POST['IdRivalteam']);     // Transform id value from string to integer

                    $play = new Play($idPlayer, $idMatch, $idRivalteam, 0, 0, null, 0);   // New Play object with parameters edited in a form from "view/Play/homePage.phtml"

                    (new DaoPlay())->deletePlayerRegistration($play);   // Call function deletePlayerFromMatch() from "Dao/daoPlay.php"

                    header('Location: index.php?playerRegistration');    // Go to page "view/Play/homePage.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

            default:
                break;
        }
    }
}
