<?php

class DaoManage
{
    public function addDate($idPicture, $idUser, $date): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO gerer(Id_Photo,Id_Utilisateur,Annee) VALUES (?,?,?)");   // Prepare the request to be execute
        try {
            $request->execute(array($idPicture, $idUser, $date,));    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deleteDate($idPicture): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM gerer WHERE Id_photo=?"); // Prepare the request to be execute

        try {
            $request->execute(array($idPicture));    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
