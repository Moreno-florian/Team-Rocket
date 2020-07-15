<?php

class DaoPlay
{
    public function showPlayList(): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(matchs.Date, \"%d-%m-%Y\") as trueDate FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match INNER JOIN equipe_adverse ON jouer.Id_equipe_adverse=equipe_adverse.Id_equipe_adverse INNER JOIN stade ON stade.Id_stade = matchs.Id_stade GROUP BY Matchs.Id_match ORDER BY matchs.Date ASC, matchs.Heure ASC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Numero_de_licence'];
                /******************************** Match table **********************************/
                $line['Id_match'];
                $line['Heure'];
                $line['Date'];
                $line['Saison'];
                $line['trueDate'];
                /****************************** RivalTeam table *********************************/
                $line['Id_equipe_adverse'];
                $line['Nom_equipe'];
                /********************************* Play table ***********************************/
                $line['But_marque_par_match'];
                $line['Passe_decisive_par_match'];
                $line['Poste'];
                $line['Temps_joue_par_match'];
                /******************************* Stadium table **********************************/
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

    public function showOnePlay($idMatch): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(matchs.Date, \"%d-%m-%Y\") as trueDate FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match INNER JOIN equipe_adverse ON jouer.Id_equipe_adverse=equipe_adverse.Id_equipe_adverse INNER JOIN stade ON stade.Id_stade = matchs.Id_stade WHERE matchs.Id_match=" . $idMatch . " ORDER BY jouer.Poste"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                /******************************* Matchs table *********************************/
                $line['Id_match'];
                $line['Date'];
                $line['trueDate'];
                /******************************* Rival team table *********************************/
                $line['Id_equipe_adverse'];
                $line['Nom_equipe'];
                /******************************* Play table *********************************/
                $line['But_marque_par_match'];
                $line['Passe_decisive_par_match'];
                $line['Poste'];
                $line['Temps_joue_par_match'];
                /******************************* Stadium table *********************************/
                $line['Id_stade'];
                $line['Nom_stade'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyPlay($play): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("UPDATE jouer SET Id_joueur='" . $play->get_idPlayer() . "',Id_match='" . $play->get_idMatch() . "',Id_equipe_adverse='" . $play->get_idRivalTeam() . "',But_marque_par_match='" . $play->get_goalByMatch() . "',Passe_decisive_par_match='" . $play->get_assist() . "',Poste='" . $play->get_position() . "',Temps_joue_par_match='" . $play->get_playTimeByMatch() . "' WHERE Id_match = " . $play->get_idMatch()); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deletePlayMatch($idMatch): void      // use id match for WHERE SQL
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM jouer WHERE Id_match = " . $idMatch); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deletePlayPlayer($idPlayer): void      // use id player for WHERE SQL
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM jouer WHERE Id_Player = " . $idPlayer); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deletePlayRivalTeam($idRvalTaem): void      // use id Rival team for WHERE SQL
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM jouer WHERE Id_equipe_adverse = " . $idRvalTaem); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    /************************************ Home page matchs list *********************************************/

    public function showPlayHomePageNotUser($season): array   // For list on Home page with user not log on site
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(matchs.Date, \"%d-%m-%Y\") as trueDate FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match INNER JOIN equipe_adverse ON jouer.Id_equipe_adverse=equipe_adverse.Id_equipe_adverse INNER JOIN stade ON stade.Id_stade = matchs.Id_stade WHERE matchs.Saison = \"" . $season . "\" GROUP BY matchs.Id_match ORDER BY matchs.Date DESC, matchs.Heure DESC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Numero_de_licence'];
                /******************************** Match table **********************************/
                $line['Id_match'];
                $line['Heure'];
                $line['Date'];
                $line['trueDate'];
                $line['Saison'];
                /****************************** RivalTeam table *********************************/
                $line['Id_equipe_adverse'];
                $line['Nom_equipe'];
                /********************************* Play table ***********************************/
                $line['But_marque_par_match'];
                $line['Passe_decisive_par_match'];
                $line['Poste'];
                $line['Temps_joue_par_match'];
                /******************************* Stadium table **********************************/
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

    public function showPlayHomePage($season): array      // For list on Home page (use session variable "PlayerID" to know if a player is registered on a match)
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT *, DATE_FORMAT(matchs.Date, \"%d-%m-%Y\") as trueDate FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match INNER JOIN equipe_adverse ON jouer.Id_equipe_adverse=equipe_adverse.Id_equipe_adverse INNER JOIN stade ON stade.Id_stade = matchs.Id_stade WHERE matchs.Saison = \"" . $season . "\" GROUP BY matchs.Id_match ORDER BY matchs.Date DESC, matchs.Heure DESC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                /******************************* Player table *********************************/
                $line['Id_joueur'];
                $line['Nom'];
                $line['Prenom'];
                $line['Annee_d_arrivee'];
                $line['Numero_de_licence'];
                /******************************** Match table **********************************/
                $line['Id_match'];
                $line['Heure'];
                $line['Date'];
                $line['trueDate'];
                $line['Saison'];
                /****************************** RivalTeam table *********************************/
                $line['Id_equipe_adverse'];
                $line['Nom_equipe'];
                /********************************* Play table ***********************************/
                $line['But_marque_par_match'];
                $line['Passe_decisive_par_match'];
                $line['Poste'];
                $line['Temps_joue_par_match'];
                /******************************* Stadium table **********************************/
                $line['Id_stade'];
                $line['Nom_stade'];
                $line['Adresse'];
                $line['Type_de_terrain'];
                $line['Commentaires'];

                $request2 = $pdo->prepare("SELECT COUNT(*) AS inscrit FROM jouer WHERE Id_joueur = " . $_SESSION['PlayerID'] . " AND Id_match = " . $line['Id_match']); // Prepare the request to be execute
                $request2->execute();    // Execute the request

                while ($line2 = $request2->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
                {
                    $line['inscrit'] = $line2['inscrit'];
                }

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    /************************************ Player registration on match ***************************************/

    public function addPlay($play): void    // Used for match creation too 
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("INSERT INTO jouer (Id_joueur,Id_match,Id_equipe_adverse,But_marque_par_match,Passe_decisive_par_match,Poste,Temps_joue_par_match) VALUES ('" . $play->get_idPlayer() . "','" . $play->get_idMatch() . "','" . $play->get_idRivalTeam() . "','" . $play->get_goalByMatch() . "','" . $play->get_assist() . "','" . $play->get_position() . "','" . $play->get_playTimeByMatch() . "')"); // Prepare the request to be execute


        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showOnePlayerRegistration($idPlayer, $idMatch): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT * FROM jouer WHERE Id_joueur= " . $idPlayer . " AND Id_MAtch=" . $idMatch); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Id_joueur'];
                $line['Id_match'];
                $line['Id_equipe_adverse'];
                $line['But_marque_par_match'];
                $line['Passe_decisive_par_match'];
                $line['Poste'];
                $line['Temps_joue_par_match'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function modifyPlayerRegistration($play): void
    {

        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("UPDATE jouer SET Id_joueur='" . $play->get_idPlayer() . "',Id_match='" . $play->get_idMatch() . "',Id_equipe_adverse='" . $play->get_idRivalTeam() . "',But_marque_par_match='" . $play->get_goalByMatch() . "',Passe_decisive_par_match='" . $play->get_assist() . "',Poste='" . $play->get_position() . "',Temps_joue_par_match='" . $play->get_playTimeByMatch() . "' WHERE Id_match = " . $play->get_idMatch() . " AND Id_joueur = " . $play->get_idPlayer()); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function deletePlayerRegistration($play): void
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $request = $pdo->prepare("DELETE FROM jouer WHERE Id_joueur = " . $play->get_idPlayer() . " AND Id_match = " . $play->get_idMatch() . " AND Id_equipe_adverse = " . $play->get_idRivalTeam()); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
