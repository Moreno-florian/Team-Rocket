<?php

class DaoPicture
{

    /******************************************* Gallery treatments *******************************************/

    public function showPictureList(): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(gerer.Annee, \"%d-%m-%Y\") as trueDate FROM photo INNER JOIN gerer ON photo.Id_Photo=gerer.Id_Photo INNER JOIN utilisateur ON gerer.Id_utilisateur=utilisateur.Id_utilisateur"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /**************************** Picture table *********************************/
                $line['Id_photo'];
                $line['Titre'];
                $line['Url_photo'];
                /***************************** Manage table *********************************/
                $line['Annee'];
                $line['trueDate'];
                /****************************** User table **********************************/
                $line['Id_utilisateur'];
                $line['Pseudo'];
                $line['Mail'];
                $line['Role'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showOnePicture($idPicture): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM photo WHERE Id_photo=" . $idPicture); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Id_photo'];
                $line['Titre'];
                $line['Url_photo'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function addPicture($picture): int
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO photo (Titre,Url_Photo) VALUES ('" . $picture->get_title() . "','" . $picture->get_urlPicture() . "')");
        try {
            $request->execute();    // Execute the request
            $newID = $pdo->lastInsertId(); // to return the ID of the new user.

            return $newID;  // return the new ID for player table

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyPicture($picture): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB

        $request = $pdo->prepare("UPDATE photo SET Titre='" . $picture->get_title() . "',Url_photo='" . $picture->get_urlPicture() . "' WHERE Id_photo=" . $picture->get_idPicture());

        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');
        }
    }

    public function deletePicture($idPicture): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM photo WHERE Id_photo=" . $idPicture); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    /***************************************** Picture files treatments *****************************************/

    public function addPictureOnGallery($newPictureInfos): string
    {
        if (isset($newPictureInfos) and !empty($newPictureInfos['name'])) {
            $maxSize = 10000000;       // The max size for the file
            $validExtension = array('jpg', 'jpeg', 'png');      // The valid extension for the file
            $newPictureName = date('dmYHis');      // Get the actual date time for rename the picture

            if ($newPictureInfos['size'] <= $maxSize) {      // If the file size is inferior or identical to the valid size;

                $uploadExtention = strtolower(substr(strrchr($newPictureInfos['name'], '.'), 1));      // strrchr = get the file extension with "." / substr = delete a character of the string
                if (in_array($uploadExtention, $validExtension)) {      // If the extension file is identical to the valid extensions;

                    $uploadFolderPath = "Img/Gallery/" . $newPictureName . "." . $uploadExtention;     // The path of the folder who the picture is saved;
                    move_uploaded_file($newPictureInfos['tmp_name'], $uploadFolderPath);      // Move the picture to the folder;
                    $folderPath = "/TeamRocket/" . $uploadFolderPath;      // Get the final folder path;
                    return $folderPath;       // Return the folder path of the picture;
                } else {
                    $errorMessage = "Votre photo doit être au format jpeg, jpg ou png";      // Create an error message;
                    return $errorMessage;       // Return error message;
                }
            } else {
                $errorMessage = "Votre photo dépasse 10Mo";      // Create an error message;
                return $errorMessage;       // Return error message;
            }
        } else {

            $errorMessage = "Vous devez ajouter une photo";      // Create an error message;
            return $errorMessage;       // Return error message;
        }
    }

    public function modifyPictureOnGallery($newPictureInfos, $OldPicturePath): string
    {
        if (isset($newPictureInfos) and !empty($newPictureInfos['name'])) {
            $maxSize = 10000000;       // The max size for the file
            $validExtension = array('jpg', 'jpeg', 'png');      // The valid extension for the file

            // $newPictureName = date('dmYHis');      // Get the actual date time for rename the picture

            if ($newPictureInfos['size'] <= $maxSize) {

                $uploadExtention = strtolower(substr(strrchr($newPictureInfos['name'], '.'), 1));      // strrchr = get the file extension with "." / substr = delete a character of the string

                if (in_array($uploadExtention, $validExtension)) {      // If the file extension is identical to the valid extensions;


                    $OldPathRename =  strrchr($OldPicturePath, 'Img');   // To delete "/TeamRocket/" from path folder;
                    move_uploaded_file($newPictureInfos['tmp_name'], $OldPathRename);   // Move the picture to the folder;
                    $folderPath = $OldPicturePath;  // Get the final folder path;
                    return $folderPath;       // Return the folder link of the picture;

                } else {
                    $errorMessage = "Votre photo doit être au format jpeg, jpg ou png";      // Create an error message;
                    return $errorMessage;       // Return error message;
                }
            } else {
                $errorMessage = "Votre photo dépasse 10Mo";      // Create an error message;
                return $errorMessage;       // Return error message;
            }
        } else {
            $folderPath = $OldPicturePath;
            return $folderPath;       // Return the folder link of the picture;
        }
    }

    public function deletePictureOnGallery($OldPicturePath): void
    {
        $OldPathRename =  strrchr($OldPicturePath, 'Img');   // To delete "/TeamRocket/" from path folder;
        unlink($OldPathRename);   // Delete the picture
    }
}
