<?php

class DaoTop
{
    public function showTopGoal($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT joueurs.Nom,joueurs.Prenom,SUM(jouer.But_marque_par_match)AS \"buts_totaux\"FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison=\"" . $season . "\" GROUP BY joueurs.Id_joueur ORDER By buts_totaux DESC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {

                $line['Nom'];
                $line['Prenom'];
                $line['buts_totaux'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showTopAssist($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT joueurs.Nom,joueurs.Prenom,SUM(jouer.Passe_decisive_par_match)AS \"passes_totale\"FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison=\"" . $season . "\" GROUP BY joueurs.Id_joueur ORDER By passes_totale DESC"); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Nom'];
                $line['Prenom'];
                $line['passes_totale'];


                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
    public function showTopTimeByMatch($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT joueurs.Nom,joueurs.Prenom,SUM(jouer.Temps_joue_par_match)AS \"temps_total\"FROM joueurs INNER JOIN jouer ON joueurs.Id_joueur=jouer.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison=\"" . $season . "\"GROUP BY joueurs.Id_joueur ORDER By temps_total DESC "); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {
                $line['Nom'];
                $line['Prenom'];
                $line['temps_total'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }

    public function showTopPresence($season): array
    {
        $pdo = Dao::getConnection();     // Connection to the DB
        $tab = [];
        $request = $pdo->prepare("SELECT joueurs.Prenom, joueurs.Nom,COUNT(jouer.Id_match) AS \"presence\" FROM jouer INNER JOIN joueurs ON jouer.Id_joueur=joueurs.Id_joueur INNER JOIN matchs ON jouer.Id_match=matchs.Id_match WHERE matchs.Saison=\"" . $season . "\" GROUP BY jouer.Id_joueur ORDER BY presence DESC "); // Prepare the request to be execute

        try {
            $request->execute();    // Execute the request

            while ($line = $request->fetch(PDO::FETCH_ASSOC))   // While all datas are not display the loop keeps going
            {

                $line['Nom'];
                $line['Prenom'];
                $line['presence'];

                $tab[] = $line;  //  $tab is where $line's containt is stocked
            }

            return $tab;
        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');    // Send the error message.		
        }
    }
}
