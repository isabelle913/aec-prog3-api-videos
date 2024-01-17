<?php

require_once __DIR__ . '../../modeles/avis.php';

// TODO  mettre controleur et modele pour avis dans dossier séparé?

class ControleurAvis {

    function afficherTousJson(){ //ok
        $resultat = new stdClass();
        $erreur = new stdClass();

        $resultat = modele_avis::ObtenirTous();

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat = "Aucun avis trouvé";
            echo json_encode($resultat);
        }
    }
   
    function afficherUnAvisJson($id) { //ok
        $resultat = new stdClass();

        $resultat = modele_avis::ObtenirUn($id);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat = "Aucun avis trouvé"; 
            echo json_encode($resultat);
        }

    }
  
   function afficherTousAvisUnVideoJson($id_video) { //ok
        $resultat = new stdClass();
    
        $resultat = modele_avis::ObtenirTousAvisUnVideo($id_video);

        if($resultat){
            echo json_encode($resultat);
        } else {
            $resultat = "Aucun avis trouvé!!!"; //ok
            echo json_encode($resultat);
        }
    }
   
    function ajouterUnAvisUrlJSON($data) { //ok
        $resultat = new stdClass(); 

        if(isset($_GET["video"]) &&
            isset($data['note']) &&  
            isset($data['commentaire'])
        ) {
            $resultat->message= modele_avis::ajouter(
                $_GET['video'], 
                $data['note'], 
                $data['commentaire'] 
            );
        } else {
            $resultat->message = "Impossible d'ajouter un avis. Des informations sont manquantes"; //ok
        }
        echo json_encode($resultat);
    }
   
    function ajouterUnAvisJSON($data) { //ok
        $resultat = new stdClass();

        if(isset($data["id_video"]) &&
            isset($data['note']) &&  
            isset($data['commentaire'])
        ) {
            $resultat->message= modele_avis::ajouter(
                $data['id_video'], 
                $data['note'], 
                $data['commentaire'] 
            );
        } else{
            $resultat->message = "Impossible d'ajouter un avis. Des informations sont manquantes"; //ok
        }
        echo json_encode($resultat);
    }

    function modifierUnAvisJSON($data) { //ok
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

    function supprimerUnAvisJSON($id){ //ok
        $resultat = new stdClass();

        $resultat->message = modele_avis::supprimer($id);
        echo json_encode($resultat);
    }
}

?>