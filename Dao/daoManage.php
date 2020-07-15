<?php

class DaoManage
{
    public function addDate($idPicture, $idUser, $date): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO gerer(Id_Photo,Id_Utilisateur,Annee) VALUES ('" . $idPicture . "','" . $idUser . "','" . $date . "')");   // Prepare the request to be execute
        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deleteDate($idPicture): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM gerer WHERE Id_photo=" . $idPicture); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
