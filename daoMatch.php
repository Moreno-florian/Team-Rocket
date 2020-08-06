<?php

class DaoMatch
{

    public function addMatch($match): int
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO matchs (heure,date,saison,Id_stade) VALUES (?,?,?,?)");   // Prepare the request to be execute

        try {
            $request->execute(array($match->get_hours(), $match->get_date(), $match->get_season(), $match->get_idStadium()));    // Execute the request
            $newId = $pdo->lastInsertId(); // to return the ID of the new user.
            return $newId;  // return the new ID for player table

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showMatchList(): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(Date, \"%d-%m-%Y\") as trueDate FROM matchs"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Id_match'];
                $line['Heure'];
                $line['Date'];
                $line['Saison'];
                $line['Id_stade'];
                $line['trueDate'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
            $request->closeCursor();
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }


    public function modifyMatch($match): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("UPDATE matchs SET heure=?,date=?,saison=?,Id_stade=? WHERE Id_match =?");    // Prepare the request to be execute

        try {
            $request->execute(array($match->get_hours(), $match->get_date(), $match->get_season(), $match->get_idStadium(), $match->get_idMatch()));    // Execute the request 
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deleteMatch($idMatch): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM matchs WHERE Id_match= ?"); // Prepare the request to be execute

        try {
            $request->execute(array($idMatch));    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
