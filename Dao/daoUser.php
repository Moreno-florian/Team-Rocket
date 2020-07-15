<?php

class DaoUser
{
    public function showUserList(): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(joueurs.Annee_d_arrivee, \"%d-%m-%Y\") as trueDate FROM utilisateur INNER JOIN joueurs ON utilisateur.Id_utilisateur = joueurs.Id_utilisateur ORDER BY utilisateur.Role ASC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* User table *********************************/
                $line['Id_utilisateur'];
                $line['Pseudo'];
                $line['Password'];
                $line['Mail'];
                $line['Role'];
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Poste_principal'];
                $line['Photo'];
                $line['Numero_de_licence'];
                $line['trueDate'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showOneUser($idUser): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM utilisateur INNER JOIN joueurs ON utilisateur.Id_utilisateur = joueurs.Id_utilisateur WHERE utilisateur.Id_utilisateur=" . $idUser); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* User table *********************************/
                $line['Id_utilisateur'];
                $line['Pseudo'];
                $line['Password'];
                $line['Mail'];
                $line['Role'];
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Poste_principal'];
                $line['Photo'];
                $line['Numero_de_licence'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function addUser($User): int
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $passwordHash = password_hash($User->get_password(),  PASSWORD_DEFAULT);    // Create a hash key for a password
        $request = $pdo->prepare("INSERT INTO utilisateur (Pseudo,Password,Mail,Role) VALUES ('" . $User->get_Pseudo() . "','" . $passwordHash . "','" . $User->get_mail() . "','" . $User->get_role() . "')"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
            $newID = $pdo->lastInsertId(); // to return the ID of the new user.

            return $newID;  // return the new ID for player table
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyUser($User): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $passwordHash = password_hash($User->get_password(),  PASSWORD_DEFAULT);    // Create a hash key for a password
        $request = $pdo->prepare("UPDATE utilisateur SET Pseudo='" . $User->get_Pseudo() . "',Password='" . $passwordHash . "',Mail='" . $User->get_mail() . "',Role='" . $User->get_role() . "' WHERE Id_utilisateur=" . $User->get_idUser()); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function connectionAccount($pseudo): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM utilisateur INNER JOIN joueurs ON utilisateur.Id_utilisateur = joueurs.Id_utilisateur WHERE utilisateur.Pseudo='" . $pseudo . "'"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going 
            {
                /******************************* User table *********************************/
                $line['Id_utilisateur'];
                $line['Pseudo'];
                $line['Password'];
                $line['Mail'];
                $line['Role'];
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Poste_principal'];
                $line['Photo'];
                $line['Numero_de_licence'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function checkPseudoAvailable($pseudo): bool
    {
        $tab = $this->showUserList();
        $valid = true;

        foreach ($tab as $key) {

            $key['Pseudo'];

            if ($pseudo == $key['Pseudo']) {
                $valid = false;
            }
        }

        return $valid;
    }

    /******************************************** Only for the administrator **************************************/

    public function deleteUser($idUser): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM utilisateur WHERE Id_utilisateur=" . $idUser); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
