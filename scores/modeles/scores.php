<?php

require_once __DIR__ . '../../../include/config.php';

class modele_scores {
  public $score;

   public function __construct($enregistrement){
    $this->score = intval($enregistrement['score']); 
  }

  public static function obtenirScore($id_video) {
    $message = new stdClass();
    $mysqli = Db::connecter();

    if ($requete = $mysqli->prepare("SELECT score FROM videos WHERE id=?")){
    
      $requete->bind_param("i", $id_video);
      $requete->execute();
      $result = $requete->get_result();

            
      if($enregistrement = $result->fetch_assoc()) {
        $message = new modele_scores($enregistrement);
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

  public static function increaseScore($id_video) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE videos SET score = score+1 WHERE id = ?")) {      

      $requete->bind_param("i", $id_video);

      if($requete->execute()) { 
          $message->msg = "Score du vidéo " . $id_video . " augmenté!"; 
      } else {
          $message =  "Une erreur est survenue lors de l'édition: " . $requete->error; 
      }
    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 
    }
    $mysqli->close();
    return $message;

  }

  public static function decreaseScore($id_video) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE videos SET score = score-1 WHERE id = ?")) {      

      $requete->bind_param("i", $id_video);

      if($requete->execute()) { 
          $message->msg = "Score du vidéo " . $id_video . " diminué!"; 
      } else {
          $message =  "Une erreur est survenue lors de l'édition: " . $requete->error; 
      }
    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 
    }
    $mysqli->close();
    return $message;
  }
}

?>


