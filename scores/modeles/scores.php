<?php

require_once __DIR__ . '../../../include/config.php';

class modele_scores {

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

      $requete->close(); 

    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 

    }
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

      $requete->close(); 

    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 

    }
    return $message;

  }

}

?>


