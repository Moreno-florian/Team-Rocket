<?php

/********************************************************** Model *************************************************************/
require_once 'Model/pictureClass.php'; // To call stadium class code.
/********************************************************* DAO class **********************************************************/
require_once 'Dao/daoPicture.php'; // To call DaoStadium class code.
require_once 'Dao/daoManage.php'; // To call DaoStadium class code.

class ControllerPicture
{
    public function runPictureProcessing(): void
    {
        /**** the condition "switch" will allow us to navigate between pages and make treatments through URLs ****/
        switch (key($_GET)) {
                /**************************************** Gallery *****************************************/
            case 'gallery':

                $list = (new DaoPicture())->showPictureList();    // Call function showPictureList() from "Dao/daoPicture.php"

                include 'View/Gallery/gallery.phtml';    // Go to page "view/Gallery/gallery.phtml"

                break;

                /************************************ Add picture form ************************************/
            case 'formAddPicture':

                if (isset($_SESSION['Role']) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    include 'View/Gallery/formAddPicture.phtml';    // Go to page "view/Gallery/formAddPicture.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /************************************ Add picture code ************************************/
            case 'addPicture':

                if (isset($_POST["Title"])) {

                    if (!empty($_POST["Title"]) and file_exists($_FILE["Picture"]['tmp_name'] . '/' . $FILES['Picture']['name'])) {  // If an important field is not empty

                        $actualUserId = intval($_SESSION['UserID']);      // Get the actual user ID for the picture and transform from string to integer
                        $date = date('Y-m-d');      // Get the actual date time for the picture

                        $urlPicture = (new DaoPicture())->addPictureOnGallery($_FILES['Picture']);    // Call function addPictureOnGallery() from "Dao/daoPicture.php"
                        $newPicture = new Picture(null, addslashes(htmlspecialchars($_POST["Title"])), $urlPicture);    // New Picture object with parameters edited in a form from "view/Gallery/formAddPicture.phtml"
                        $newId = (new DaoPicture())->addPicture($newPicture);    // Call function addPicture() from "Dao/daoPicture.php"

                        (new DaoManage())->addDate($newId, $actualUserId, $date);    // Call function addDate() from "Dao/DaoManage.php"

                        header('Location: index.php?gallery');    // Go to page "view/Gallery/gallery.phtml"
                    } else {

                        $_SESSION["error"] = "Veuillez remplir les champs avec *";    // Create an error message
                        header('Location: index.php?formAddPicture');    // Go to page "view/Play/homePage.phtml"
                    }
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Modify picture form ***********************************/
            case 'formModifyPicture':

                if ((isset($_POST['IdPicture']) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idPicture = intval($_POST['IdPicture']);   // Transform id value from string to integer

                    $picture = (new DaoPicture())->showOnePicture($idPicture);      // Call function showOneStadium() from 'Dao/daoStadium.php'

                    foreach ($picture as $key) {
                        $key['Id_photo'];
                        $key['Titre'];
                        $key['Url_photo'];
                    }

                    include "View/Gallery/formModifyPicture.phtml";    // Go to page "/View/Gallery/formModifyPicture.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Modify picture code ***********************************/
            case 'modifyPicture':

                if (isset($_POST['IdPicture'])) {

                    $idPicture = intval($_POST['IdPicture']);   // Transform id value from string to integer

                    $picture = (new DaoPicture())->showOnePicture($idPicture);      // Call function showOnePicture() from 'Dao/daoPicture.php'
                    $urlPicture = (new DaoPicture())->modifyPictureOnGallery($_FILES['Picture'], $_POST['OldPicture']);      // Call function modifyPictureOnGallery() from 'Dao/daoPicture.php'
                    $modPicture = new Picture($idPicture, addslashes(htmlspecialchars($_POST["Title"])), $urlPicture); // New Picture object with parameters edited in a form from "view/Gallery/formModifyPicture.phtml"

                    (new DaoPicture())->modifyPicture($modPicture);      // Call function modifyPicture() from 'Dao/daoPicture.php'

                    header('Location: index.php?gallery');    // Go to page "view/Gallery/gallery.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

                /*********************************** Delete picture code ***********************************/
            case 'deletePicture':
                if ((isset($_POST['IdPicture']) and isset($_SESSION['Role'])) and ($_SESSION['Role'] == "Administrateur" or $_SESSION['Role'] == "Modérateur")) { // If the user is "Administrateur" or "Modérateur"

                    $idPicture = intval($_POST['IdPicture']);   // Transform id value from string to integer

                    (new DaoManage())->deleteDate($idPicture);;      // Call function deleteDate() from 'Dao/daoManage.php'
                    (new DaoPicture())->deletePictureOnGallery($_POST['UrlPicture']);;      // Call function deletePictureOnGallery() from 'Dao/daoPicture.php'
                    (new DaoPicture())->deletePicture($idPicture);;      // Call function deletePicture() from 'Dao/daoPicture.php'

                    header('Location: index.php?gallery');    // Go to page "view/Gallery/gallery.phtml"
                } else {

                    header('Location: index.php');    // Go to page "view/Play/homePage.phtml"
                }
                break;

            default:
                break;
        }
    }
}
