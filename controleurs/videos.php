<?php

require_once __DIR__ . '../../modeles/videos.php';

class ControleurVideos {

    function afficherTousJson(){
     $resultat = new stdClass();

        // $videos = modele_videos::ObtenirTous();
        // echo json_encode($videos);

        $resultat = modele_videos::ObtenirTous();

        if($resultat){
            echo json_encode($resultat);
        } else {
            $erreur->message = "Aucun vidéo trouvé"; 
            echo json_encode($erreur);
        }
    }

    function afficherUnJson() {
        $erreur = new stdClass(); // pour qu'erreur soit un objet, ensuite l'utilisé en objet

        // je pourrais recevoir l'id en paramètre dans afficherUnJson($id) via index.php et ne pas faire le 1er if
        // $video= modele_videos::ObtenirUn($id);
        // echo json_encode($video);
    
        if(isset($_GET['id'])){
            $video = modele_videos::ObtenirUn($_GET['id']);

            if($video){
                echo json_encode($video);
            } else {
                $erreur->message = "Aucun vidéo trouvé"; 
                echo json_encode($erreur);
            }
        } else {
            $erreur->message = "L'identifiant (id) du vidéo à afficher est manquant dans l'url";
            echo json_encode($erreur);
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
            isset($data['subtitle'])
        ) {
            $resultat->message= modele_videos::ajouter(
                $data['code'], 
                $data['date_publication'], 
                $data['description'], 
                $data['duree'], 
                $data['media'],
                $data['nom'],
                $data['subtitle'],
            );
        } else{
            $resultat->message = "Impossible d'ajouter un produit. Des informations sont manquantes";
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
            isset($data['subtitle'])
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
            );
        } else{
            $resultat->message = "Impossible de modifier ce vidéo. Des informations sont manquantes";
        }
        echo json_encode($resultat);
    }

    function supprimerJSON($id){
        $resultat = new stdClass();

        $resultat->message = modele_videos::supprimer($_GET['id']);
        echo json_encode($resultat);

        //TODO ?? si je supprime un vidéo inexistant ou déja supprimé il me dit vidéo supprimé, mais MySQL dit 0 ligne supprimé, contrairement si vraiment supprimé MySQL dit 1 ligne supprimé 

    }

// TODO standardiser les messages vs erreur (new stdClass)
}


?>