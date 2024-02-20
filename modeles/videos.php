<?php

require_once __DIR__ . '../../include/config.php';

class modele_videos {
  public $id; 
  public $code; 
  public $date_publication; 
  public $description; 
  public $duree; 
  public $media; 
  public $nom; 
  public $subtitle; 
  public $nb_vues;
  public $score;
  public $categories;

  public function __construct($enregistrement){
    $this->id = $enregistrement['id']; 
    $this->code = $enregistrement['code']; 
    $this->date_publication = $enregistrement['date_publication']; 
    $this->description = $enregistrement['description']; 
    $this->duree = floatval($enregistrement['duree']); 
    $this->media = $enregistrement['media']; 
    $this->nom = $enregistrement['nom']; 
    $this->subtitle = $enregistrement['subtitle'];  
    $this->nb_vues = intval($enregistrement['nb_vues']);  
    $this->score = intval($enregistrement['score']);  
    $this->categories = explode(';', $enregistrement['categories']);
  }

  public static function ObtenirTous() {
    $liste = [];
    $mysqli = Db::connecter();
    $message = new stdClass();

    $resultatRequete = $mysqli->query("SELECT * FROM videos");

    if($resultatRequete){
      foreach ($resultatRequete as $enregistrement) {
        $liste[] = new modele_videos($enregistrement);
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

    if ($requete = $mysqli->prepare("SELECT * FROM videos WHERE id=?")){
    
      $requete->bind_param("i", $id);
      $requete->execute();
      $result = $requete->get_result();

      if($enregistrement = $result->fetch_assoc()) {
        $message = new modele_videos($enregistrement);
      } else {
        http_response_code(404);
        $message->msg = "Erreur: Aucun enregistrement trouvé.";
      }
  
    } else {
      http_response_code(500); 
      $message->msg =  "Une erreur a été détectée dans la requête utilisée : ";   
      $message->error = $mysqli->error;
    }
    $mysqli->close();
    return $message;
  }

  public static function ajouter( $code, $date_publication, $description, $duree, $media, $nom, $subtitle, $categories) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("INSERT INTO videos(code, date_publication, description, duree, media, nom, subtitle, categories) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")) {      
      $categories_str = implode(';', $categories);

      $requete->bind_param("sssissss", $code, $date_publication, $description, $duree, $media, $nom, $subtitle, $categories_str);

      if($requete->execute()) { 
          $message = "Vidéo ajoutée"; 
      } else {
          $message->msg = "Une erreur est survenue lors de l'ajout: "; 
          $message->error =  $mysqli->error; 
      }
    } else  {
      $message->msg =  "Une erreur a été détectée dans la requête utilisée." ;
      $message->error =  $mysqli->error; 
    }
    $mysqli->close();
    return $message;
  }
  
  public static function modifier($id, $code, $date_publication, $description, $duree, $media, $nom, $subtitle, $categories) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE videos SET code=?, date_publication=?, description=?, duree=?, media=?, nom=?, subtitle=?, categories=? WHERE id=?")) {   
       $categories_str = implode(';', $categories);   

      $requete->bind_param("sssissssi", $code, $date_publication, $description, $duree, $media, $nom, $subtitle, $categories_str, $id  );

      if($requete->execute()) { 
          $message = "Vidéo modifiée"; 
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

  public static function supprimer($id) {
    $message = new stdClass();
    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("DELETE FROM videos WHERE id=?")) {      

      $requete->bind_param("i", $id);

      if($requete->execute()) { 
          $message = "Vidéo supprimée: " . $id; 
      } else {
          $message->msg =  "Une erreur est survenue lors de la suppression: ";  
          $message->error = $requete->error;  
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
