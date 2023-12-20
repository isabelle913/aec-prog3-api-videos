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

  public function __construct($enregistrement){
    $this->id = $enregistrement['id']; 
    $this->code = $enregistrement['code']; 
    $this->date_publication = $enregistrement['date_publication']; 
    $this->description= $enregistrement['description']; 
    $this->duree= $enregistrement['duree']; 
    $this->media= $enregistrement['media']; 
    $this->nb_vues= $enregistrement['nb_vues']; 
    $this->nom= $enregistrement['nom']; 
    $this->subtitle= $enregistrement['subtitle'];  
    $this->score= $enregistrement['score'];  
  }

  public static function ObtenirTous() {
    $liste = [];
    $mysqli = Db::connecter();
    $message = '';

    $resultatRequete = $mysqli->query("SELECT * FROM videos");

    if($resultatRequete){
      foreach ($resultatRequete as $enregistrement) {
        $liste[] = new modele_videos($enregistrement);
      }
      return $liste;
    } else {
       $message =  "Une erreur est survenue lors de la requête!";
       return $message;
    }
   
  }
  
  public static function ObtenirUn($id) {
      
    $mysqli = Db::connecter();

    if ($requete = $mysqli->prepare("SELECT * FROM videos WHERE id=?")){
    
      $requete->bind_param("i", $id);

      $requete->execute();

      $result = $requete->get_result();

      if($enregistrement = $result->fetch_assoc()) {
        $video = new modele_videos($enregistrement);
      } else {
          echo "Erreur: Aucun enregistrement trouvé."; // TODO ?? Est-ce nécessaire le controleur retourne déja un message
          return null;
      }

      $requete->close();
    } else {
      echo "Une erreur a été détectée dans la requête utilisée : ";   
      echo $mysqli->error;
      return null;
    }

    return $video;
  }

  public static function ajouter( $code, $date_publication, $description, $duree, $media, $nom, $subtitle) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("INSERT INTO videos(code, date_publication, description, duree, media, nom, subtitle) VALUES(?, ?, ?, ?, ?, ?, ?)")) {      

    $requete->bind_param("sssisss", $code, $date_publication, $description, $duree, $media, $nom, $subtitle);

    if($requete->execute()) { 
        $message = "Vidéo ajouté"; 
    } else {
        $message =  "Une erreur est survenue lors de l'ajout: " . $requete->error; 
    }

    $requete->close(); 

    } else  {
        echo "Une erreur a été détectée dans la requête utilisée : ";   
        echo $mysqli->error;
        echo "<br>";
        exit();
    }

    return $message;
  }
  
  public static function modifier($id, $code, $date_publication, $description, $duree, $media, $nom, $subtitle) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("UPDATE videos SET code=?, date_publication=?, description=?, duree=?, media=?, nom=?, subtitle=? WHERE id=?")) {      

    $requete->bind_param("sssisssi", $code, $date_publication, $description, $duree, $media, $nom, $subtitle, $id);

    if($requete->execute()) { 
        $message = "Vidéo modifié"; 
    } else {
        $message =  "Une erreur est survenue lors de l'édition: " . $requete->error; 
    }

    $requete->close(); 

    } else  {
        echo "Une erreur a été détectée dans la requête utilisée : ";   
        echo $mysqli->error;
        echo "<br>";
        exit();
    }
// TODO le 2e else devrait être différent
    return $message;
  }

  public static function supprimer($id) {
    $message = '';

    $mysqli = Db::connecter();
    
    if ($requete = $mysqli->prepare("DELETE FROM videos WHERE id=?")) {      

      $requete->bind_param("i", $id);

      if($requete->execute()) { 
          $message = "Vidéo supprimé: " . $id; 
      } else {
          $message =  "Une erreur est survenue lors de la suppression: " . $requete->error;  
      }

      $requete->close(); 

    } else  {
      // TODO ?? je n'arrive pas a atteindre cette erreur
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
