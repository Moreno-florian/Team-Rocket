<?php

class DaoStadium
{
    public function showStadiumList(): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM stade"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Id_stade'];
                $line['Nom_stade'];
                $line['Adresse'];
                $line['Type_de_terrain'];
                $line['Commentaires'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showOneStadium($idStadium): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM stade WHERE Id_stade=" . $idStadium); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Id_stade'];
                $line['Nom_stade'];
                $line['Adresse'];
                $line['Type_de_terrain'];
                $line['Commentaires'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function addStadium($stadium): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO stade (Nom_stade,Adresse,Type_de_terrain,Commentaires) VALUES ('" . $stadium->get_name() . "','" . $stadium->get_adress() . "','" . $stadium->get_groundType() . "','" . $stadium->get_commentary() . "')");  // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyStadium($stadium): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB

        $request = $pdo->prepare("UPDATE stade SET Nom_stade='" . $stadium->get_name() . "',Adresse='" . $stadium->get_adress() . "',Type_de_terrain='" . $stadium->get_groundType() . "',Commentaires='" . $stadium->get_commentary() . "' WHERE Id_stade=" . $stadium->get_idStadium());  // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deleteStadium($idStadium): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM stade WHERE Id_stade=" . $idStadium); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
