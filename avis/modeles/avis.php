<?php

require_once __DIR__ . '../../../include/config.php';

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

  public static function ObtenirTous() {
    $liste = [];
    $message = new stdClass();
    $mysqli = Db::connecter();

    $resultatRequete = $mysqli->query("SELECT * FROM avis");

    if($resultatRequete){
      foreach ($resultatRequete as $enregistrement) {
        $liste[] = new modele_avis($enregistrement);
      }
      $mysqli->close();
      return $liste;

    } else {
       $message->msg =  "Une erreur est survenue lors de la requête!";
       $message->error = $mysqli->error;
       $mysqli->close();
       return $message;
    }
  }
 
  public static function ObtenirUn($id) {
    $mysqli = Db::connecter();
    $message = new stdClass();

    if ($requete = $mysqli->prepare("SELECT * FROM avis WHERE id=?")){
    
      $requete->bind_param("i", $id);
      $requete->execute();
      $resultatRequete = $requete->get_result();

      if($enregistrement = $resultatRequete->fetch_assoc()) {
        $message = new modele_avis($enregistrement);
      } else {
        $message = "Erreur: Aucun enregistrement trouvé.";
      }
    } else {
      $message->msg = "Une erreur a été détectée dans la requête utilisée.";
      $message->error = $mysqli->error;
    }
    $mysqli->close();
    return $message;
  }

  public static function ObtenirTousAvisUnVideo($id_video) {
    $liste = [];    
    $message = new stdClass();
    $mysqli = Db::connecter();

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
        $message =  "Une erreur est survenue lors de la requête!";
      }
    } else {
      $message->msg = "Une erreur a été détectée dans la requête utilisée.";
      $message->error = $mysqli->error;   
    }
    $mysqli->close();
    return $message;
  }

  public static function ajouter( $id_video, $note, $commentaire) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("INSERT INTO avis(id_video, note, commentaire) VALUES(?, ?, ?)")) {  

      $requete->bind_param("iis", $id_video, $note, $commentaire);

      if($requete->execute()) { 
          $message = "Avis ajouté"; 
      } else {
          $message =  "Une erreur est survenue lors de l'ajout: " . $requete->error; 
      }
    } else  {
      $message->msg = "Une erreur a été détectée dans la requête utilisée.";
      $message->error = $mysqli->error;
    }
    $mysqli->close();
    return $message;
  }
  
  public static function modifier($id, $id_video, $note, $commentaire) {
    $message = new stdClass();

    if(!$id){
      $message =  "L'identifiant (id) de l'avis est manquant dans l'url! ";
      return $message;
    }

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE avis SET id_video=?, note=?, commentaire=? WHERE id=?")) {      

      $requete->bind_param("iisi", $id_video, $note, $commentaire, $id);

      if($requete->execute()) { 
          $message = "Avis modifié";
      } else {
          $message->msg =  "Une erreur est survenue lors de l'édition"; 
          $message->error =  $mysqli->error; 
      }
    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 
    }
    $mysqli->close();
    return $message;
  }

  public static function supprimer($id) {
    $message = new stdClass();

    if(!$id){
      $message =  "L'identifiant (id) de l'avis est manquant dans l'url! ";
      return $message;
    }

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("DELETE FROM avis WHERE id=?")) {      

      $requete->bind_param("i", $id);

      if($requete->execute()) { 
          $message = "Avis supprimé: " . $id;
      } else {
          $message->msg =  "Une erreur est survenue lors de la suppression.";  
          $message->error =  $mysqli->error; 
      }
    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée."; 
      $message->error =  $mysqli->error; 
    }
    $mysqli->close();
    return $message;
  }

}

?>
