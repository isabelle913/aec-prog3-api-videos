<?php

require_once __DIR__ . '../../modeles/avis.php';

// TODO ?? doit-on mettre controleur et modele pour avis dans dossier séparé?

class ControleurAvis {

    function afficherTousJson(){
    //  $resultat = new stdClass();
        $erreur = new stdClass();

        $resultat = modele_avis::ObtenirTous();

        if($resultat){
            echo json_encode($resultat);
        } else {
            $erreur->message = "Aucun avis trouvé"; // pour tester il faudrait que je vide ma bd!
            echo json_encode($erreur);
        }
    }
   
    function afficherUnAvisJson() {
        $erreur = new stdClass();

        if(isset($_GET['id'])){
            $resultat = modele_avis::ObtenirUn($_GET['id']);

            if($resultat){
                echo json_encode($resultat);
            } else {
                $erreur->message = "Aucun avis trouvé"; 
                echo json_encode($erreur);
            }
        } else {
            $erreur->message = "L'identifiant (id) de l'avis à afficher est manquant dans l'url"; // TODO ?? pourquoi j'obtiens pas
            echo json_encode($erreur);
        }
    }
  
   function afficherTousAvisUnVideoJson() {
        $erreur = new stdClass();

        if(isset($_GET['video'])){  // id_video
            $resultat = modele_avis::ObtenirTousAvisUnVideo($_GET['video']);

            if($resultat){
                echo json_encode($resultat);
            } else {
                $erreur->message = "Aucun avis trouvé"; 
                echo json_encode($erreur);
            }
        } else {
            $erreur->message = "L'identifiant (id_video) du vidéo des avis à afficher est manquant dans l'url";
            echo json_encode($erreur);
        }
    }
   
    function ajouterUnAvisUrlJSON($data) {
        $resultat = new stdClass(); // TODO ?? pourquoi ici je doit créer l'objet et pas aux autres places?
        $erreur = new stdClass();

        if(isset($_GET["video"]) && // id_video
            isset($data['note']) &&  
            isset($data['commentaire'])
        ) {
            $resultat->message= modele_avis::ajouter(
                $_GET['video'], 
                $data['note'], 
                $data['commentaire'] 
            );
             echo json_encode($resultat);
        } else{
            $erreur->message = "Impossible d'ajouter un avis. Des informations sont manquantes"; //ok
            echo json_encode($erreur);
        }
    }
   
    function ajouterUnAvisJSON($data) {
        $resultat = new stdClass();
        $erreur = new stdClass();

        if(isset($data["id_video"]) &&
            isset($data['note']) &&  
            isset($data['commentaire'])
        ) {
            $resultat->message= modele_avis::ajouter(
                $data['id_video'], 
                $data['note'], 
                $data['commentaire'] 
            );
             echo json_encode($resultat);
        } else{
            $erreur->message = "Impossible d'ajouter un avis. Des informations sont manquantes"; //ok
            echo json_encode($erreur);
        }
    }

    function modifierUnAvisJSON($data) {
        $resultat = new stdClass();

        if(isset($_GET["id"]) &&
            isset($data['id_video']) && 
            isset($data['note']) &&  
            isset($data['commentaire'])
        ) {
            $resultat->message= modele_avis::modifier(
                $_GET["id"],
                $data['id_video'], 
                $data['note'], 
                $data['commentaire'] 
            );
        } else{
            $resultat->message = "Impossible de modifier cet avis. Des informations sont manquantes"; //ok
        }
        echo json_encode($resultat);
    }

    function supprimerUnAvisJSON(){
        $resultat = new stdClass();

        $resultat->message = modele_avis::supprimer($_GET['id']);
        echo json_encode($resultat);

    }

// TODO standardiser les messages vs erreur (new stdClass)
}


?>