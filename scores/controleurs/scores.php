<?php

require_once __DIR__ . '../../modeles/scores.php';

class ControleurScores {

    function afficherScore($id_video){
        $resultat = new stdClass();
          
        $resultat = modele_scores::obtenirScore($id_video);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat->message = "Aucun score trouvé";
            echo json_encode($resultat);
        }
    }

    function increaseScore($id_video) {
        $resultat = new stdClass();
          
        $resultat = modele_scores::increaseScore($id_video);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat->message = "Aucun score trouvé";
            echo json_encode($resultat);
        }
    }

    function decreaseScore($id_video) {
        $resultat = new stdClass();
          
        $resultat = modele_scores::decreaseScore($id_video);

        if($resultat){
            echo json_encode($resultat);
        } else {
             $resultat->message = "Aucun score trouvé";
            echo json_encode($resultat);
        }
    }

     function modifierScore($id_video, $action) {
        $resultat = new stdClass();
          
        $resultat = modele_scores::modifierScore($id_video, $action);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat->message = "Aucun score trouvé";
            echo json_encode($resultat);
        }
    }

}

?>