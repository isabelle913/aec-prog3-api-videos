<?php

require_once __DIR__ . '../../modeles/videos.php';

// TODO Catégorie selon utilisation dans Angular
// TODO Utilisateur

class ControleurVideos {

    function afficherTousJson(){
        $resultat = new stdClass(); 

        $resultat = modele_videos::ObtenirTous();

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat->message = "Aucune vidéo trouvée"; 
            echo json_encode($resultat);
        }
    }

    function afficherUnJson($id) {
        $resultat = new stdClass();
          
        $resultat = modele_videos::ObtenirUn($id);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat->message = "Aucune vidéo trouvée";
            echo json_encode($resultat);
        }
    }
    
    function ajouterJSON($data) {
        $resultat = new stdClass();

        if(isset($data['code']) && 
            isset($data['date_publication']) &&  
            isset($data['description']) && 
            isset($data['duree']) && 
            isset($data['media'])&& 
            isset($data['nom'])&& 
            isset($data['subtitle'])&&
            isset($data['categories'])
        ) {
            $resultat->message= modele_videos::ajouter(
                $data['code'], 
                $data['date_publication'], 
                $data['description'], 
                $data['duree'], 
                $data['media'],
                $data['nom'],
                $data['subtitle'],
                $data['categories'],
            );
        } else{
            $resultat->message = "Impossible d'ajouter une vidéo. Des informations sont manquantes!!!";
        }
        echo json_encode($resultat);
    }

    function modifierJSON($data) {
        $resultat = new stdClass();

        if(isset($_GET["id"]) &&
            isset($data['code']) && 
            isset($data['date_publication']) &&  
            isset($data['description']) && 
            isset($data['duree']) && 
            isset($data['media'])&& 
            isset($data['nom'])&& 
            isset($data['subtitle'])&&
            isset($data['categories'])
        ) {
            $resultat->message= modele_videos::modifier(
                $_GET["id"],
                $data['code'], 
                $data['date_publication'], 
                $data['description'], 
                $data['duree'], 
                $data['media'],
                $data['nom'],
                $data['subtitle'],
                $data['categories'],
            );
        } else{
            $resultat->message = "Impossible de modifier ce vidéo. Des informations sont manquantes!!!";
        }
        echo json_encode($resultat);
    }

    function supprimerJSON($id){ 
        $resultat = new stdClass();

        $resultat->message = modele_videos::supprimer($_GET['id']);
        echo json_encode($resultat);

    }

}


?>