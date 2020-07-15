<?php

class DaoPlayer
{
    public function addPlayer($player): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO joueurs (Nom,Prenom,Annee_d_arrivee,Poste_principal,Photo,Numero_de_licence,Id_utilisateur) VALUES ('" . $player->get_lastname() . "','" . $player->get_firstname() . "', '" . $player->get_arrivalYear() . "','" . $player->get_position() . "','" . $player->get_picture() . "', '" . $player->get_licenseNumber() . "','" . $player->get_idUser() . "')");     // Prepare the request to be execute
        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyPlayer($player): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("UPDATE joueurs SET Nom='" . $player->get_lastname() . "',Prenom='" . $player->get_firstname() . "',Annee_d_arrivee='" . $player->get_arrivalYear() . "',Poste_principal='" . $player->get_position() . "',Photo='" . $player->get_picture() . "',Numero_de_licence='" . $player->get_licenseNumber() . "' WHERE Id_joueur=" . $player->get_idPlayer());     // Prepare the request to be execute
                                   
        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {

            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    /****************************************** Pictures profiles *******************************************/

    public function addPictureProfile($newPictureInfos): string
    {
        if (isset($newPictureInfos) and !empty($newPictureInfos['name'])) {
            $maxSize = 10000000;       // The max size for the file
            $validExtension = array('jpg', 'jpeg', 'png');      // The valid extension for the file
            $newPictureName = date('dmYHis');      // Get the actual date time for rename the picture
            // TODO tester format MIME
            if ($newPictureInfos['size'] <= $maxSize) {      // If the file size is inferior or identical to the valid size;

                $uploadExtention = strtolower(substr(strrchr($newPictureInfos['name'], '.'), 1));      // strrchr = get the file extension with "." / substr = delete a character of the string
                if (in_array($uploadExtention, $validExtension)) {      // If the extension file is identical to the valid extensions;

                    $uploadFolderPath = "Img/Players/" . $newPictureName . "." . $uploadExtention;     // The path of the folder who the picture is saved;
                    move_uploaded_file($newPictureInfos['tmp_name'], $uploadFolderPath);      // Move the picture to the folder;
                    $folderPath = "/TeamRocket/" . $uploadFolderPath;      // Get the final folder path;
                    return $folderPath;       // Return the folder path of the picture;
                } else {
                    $folderPath = "/TeamRocket/Img/Players/default.jpg";   // use default picture;
                    return $folderPath;       // Return the folder link of the picture;
                }
            } else {
                $folderPath = "/TeamRocket/Img/Players/default.jpg";   // use default picture;
                return $folderPath;       // Return the folder link of the picture;
            }
        } else {
            $folderPath = "/TeamRocket/Img/Players/default.jpg";   // use default picture;
            return $folderPath;       // Return the folder link of the picture;
        }
    }

    public function modifyPictureProfile($newPictureInfos, $OldPicturePath): string
    {
        if (isset($newPictureInfos) and !empty($newPictureInfos['name'])) {
            $maxSize = 10000000;       // The max size for the file
            $validExtension = array('jpg', 'jpeg', 'png');      // The valid extension for the file
            $newPictureName = date('dmYHis');      // Get the actual date time for rename the picture

            if ($newPictureInfos['size'] <= $maxSize) {

                $uploadExtention = strtolower(substr(strrchr($newPictureInfos['name'], '.'), 1));      // strrchr = get the file extension with "." / substr = delete a character of the string

                if (in_array($uploadExtention, $validExtension)) {      // If the file extension is identical to the valid extensions;

                    if ($OldPicturePath == "/TeamRocket/Img/Players/default.jpg") {     // To keep the default picture

                        $uploadFolderPath = "Img/Players/" . $newPictureName . "." . $uploadExtention;     // The path of the folder who the picture is saved;
                        move_uploaded_file($newPictureInfos['tmp_name'], $uploadFolderPath);      // Move the picture to the folder;
                        $folderPath = "/TeamRocket/" . $uploadFolderPath;      // Get the final folder path;
                        return $folderPath;       // Return the folder link of the picture;

                    } else {

                        $OldPathRename =  strrchr($OldPicturePath, 'Img');   // To delete "/TeamRocket/" from path folder;
                        move_uploaded_file($newPictureInfos['tmp_name'], $OldPathRename);   // Move the picture to the folder;
                        $folderPath = $OldPicturePath;  // Get the final folder path;
                        return $folderPath;       // Return the folder link of the picture;
                    }
                } else {
                    $folderPath = "/TeamRocket/Img/Players/default.jpg";   // use default picture;
                    return $folderPath;       // Return the folder link of the picture;
                }
            } else {
                $folderPath = "/TeamRocket/Img/Players/default.jpg";   // use default picture;
                return $folderPath;       // Return the folder link of the picture;
            }
        } else {
            $folderPath = $OldPicturePath;
            return $folderPath;       // Return the folder link of the picture;
        }
    }

    /*************************************** Only for the administrator **************************************/

    public function deletePlayer($idPlayer): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM joueurs WHERE joueurs.Id_joueur = " . $idPlayer); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deletePictureProfile($OldPicturePath): void
    {
        if ($OldPicturePath != "/TeamRocket/Img/Players/default.jpg") { // To keep the default picture

            $OldPathRename =  strrchr($OldPicturePath, 'Img');   // To delete "/TeamRocket/" from path folder;
            unlink($OldPathRename);   // Delete the picture;
        }
    }
}