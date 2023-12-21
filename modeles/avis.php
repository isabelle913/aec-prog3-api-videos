<?php

require_once __DIR__ . '../../include/config.php';

class modele_avis {
  public $id; 
  public $id_video; 
  public $note; 
  public $commentaire; 

  public function __construct($enregistrement){
    $this->id = $enregistrement['id']; 
    $this->id_video = $enregistrement['id_video']; 
    $this->note = $enregistrement['note']; 
    $this->commentaire= $enregistrement['commentaire']; 
  }

  //ok
  public static function ObtenirTous() {
    $liste = [];
    $mysqli = Db::connecter();
    $message = '';

    $resultatRequete = $mysqli->query("SELECT * FROM avis");

    if($resultatRequete){
      foreach ($resultatRequete as $enregistrement) {
        $liste[] = new modele_avis($enregistrement);
      }
      return $liste;

    } else {
       $message =  "Une erreur est survenue lors de la requête!";
       return $message;
    }
   
  }
  //ok
  public static function ObtenirUn($id) {
    $mysqli = Db::connecter();
    $message = '';

    if ($requete = $mysqli->prepare("SELECT * FROM avis WHERE id=?")){
    
      $requete->bind_param("i", $id);

      $requete->execute();

      $resultatRequete = $requete->get_result();

      if($enregistrement = $resultatRequete->fetch_assoc()) { // TODO ?? pourquoi le fetch_assoc
        $avis = new modele_avis($enregistrement);
        return $avis;
      } else {
        $message = "Erreur: Aucun enregistrement trouvé.";
        return $message;
      }
      $requete->close(); 

    } else {
      $message = "Une erreur a été détectée dans la requête utilisée : " .  $mysqli->error;
      return $message;
    }
  }

  public static function ObtenirTousAvisUnVideo($id_video) {
    $liste = [];    
    $mysqli = Db::connecter();
    $message = '';

    if ($requete = $mysqli->prepare("SELECT * FROM avis WHERE id_video=?")){
    
      $requete->bind_param("i", $id_video);

      $requete->execute();

      $resultatRequete = $requete->get_result();

      if($resultatRequete) {
        foreach ($resultatRequete as $enregistrement) {
          $liste[] = new modele_avis($enregistrement);
        }
        return $liste;
      } else {
        $message =  "Une erreur est survenue lors de la requête!"; // TODO ?? comment arriver à cette erreur
        return $message;
      }

      $requete->close(); // TODO est-ce que ma requête sera close puisque retour avant?
    } else {
      $message = "Une erreur a été détectée dans la requête utilisée : " . $mysqli->error;   
      return $message;
    }
  }

  public static function ajouter( $id_video, $note, $commentaire) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("INSERT INTO avis(id_video, note, commentaire) VALUES(?, ?, ?)")) {  

      $requete->bind_param("iis", $id_video, $note, $commentaire);

      if($requete->execute()) { 
          $message = "Avis ajouté"; 
      } else {
          $message =  "Une erreur est survenue lors de l'ajout: " . $requete->error; 
      }

      $requete->close(); 

    } else  {
      $message = "Une erreur a été détectée dans la requête utilisée : " . $mysqli->error;   // TODO pas testé 
      return $message;
        // echo "Une erreur a été détectée dans la requête utilisée : ";   
        // echo $mysqli->error;
        // echo "<br>";
        // exit();
    }

    return $message;
  }
  
  public static function modifier($id, $id_video, $note, $commentaire) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE avis SET id_video=?, note=?, commentaire=? WHERE id=?")) {      

      $requete->bind_param("iisi", $id_video, $note, $commentaire, $id);

      if($requete->execute()) { 
          $message = "Avis modifié";  // TODO trouver erreur il envoie ce message même si pas id dans l'url
      } else {
          $message =  "Une erreur est survenue lors de l'édition: " . $requete->error; 
      }

      $requete->close(); 

    } else  {
      $message = "Une erreur a été détectée dans la requête utilisée : " . $mysqli->error;   // TODO pas testé 
      return $message;
        // echo "Une erreur a été détectée dans la requête utilisée : ";   
        // echo $mysqli->error;
        // echo "<br>";
        // exit();
    }

    return $message;
  }

  // Supprime l'avis et non les avis d'un vidéo
  public static function supprimer($id) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("DELETE FROM avis WHERE id=?")) {      

      $requete->bind_param("i", $id);

      if($requete->execute()) { 
          $message = "Avis supprimé: " . $id; 
      } else {
          $message =  "Une erreur est survenue lors de la suppression: " . $requete->error;  
      }

      $requete->close(); 

    } else  {
     
       $message =  "Une erreur a été détectée dans la requête utilisée : " . $mysqli->error; 
        // echo "Une erreur a été détectée dans la requête utilisée : ";
        // echo $mysqli->error;
        // echo "<br>";
        exit();
    }

    return $message;
  }


}


?>
