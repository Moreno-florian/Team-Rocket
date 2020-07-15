<?php

class DaoStat
{
    public function showGoal($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT SUM(But_marque_par_match) AS \"total buts\" FROM jouer INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison='" . $season . "' AND jouer.Id_joueur=" . $_SESSION["PlayerID"]); // Prepare the request to be execute
        

        try {
            $request->execute();    // Execute the request


            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['total buts'];


                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showPass($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT SUM(Passe_decisive_par_match) AS \"total passes\" FROM jouer INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE  matchs.Saison='" . $season . "' AND jouer.Id_joueur=" . $_SESSION["PlayerID"]); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request


            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['total passes'];


                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showTime($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT SUM(Temps_joue_par_match) AS \"total temps de jeu\" FROM jouer INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE  matchs.Saison='" . $season . "' AND jouer.Id_joueur=" . $_SESSION["PlayerID"]); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request


            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['total temps de jeu'];


                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showPresence($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT joueurs.Prenom, joueurs.Nom,COUNT(jouer.Id_match) AS \"presence\" FROM jouer INNER JOIN joueurs ON jouer.Id_joueur=joueurs.Id_joueur 
                                                                                                                        INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison='" . $season . "' 
                                                                                                                                                                     AND joueurs.Id_joueur=" . $_SESSION["PlayerID"] );
        
        try {
            $request->execute();    // Execute the request


            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['presence'];


                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
