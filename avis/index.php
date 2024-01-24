<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *'); 
  require_once'./controleurs/avis.php';
  $ControleurAvis = new ControleurAvis;

  switch($_SERVER['REQUEST_METHOD']) {
    case'GET':
      if (isset($_GET['id'])) { 
        $ControleurAvis->afficherUnAvisJson($_GET['id']); // Obtenir juste un avis
      } else if(isset($_GET['video'])){
        $ControleurAvis->afficherTousAvisUnVideoJson($_GET['video']);// Obtenir tous les avis d'un vidéo
      } else {
        $ControleurAvis->afficherTousJson(); // Affiche tous les avis de tous les vidéos
      }
      break;
    case'POST':
      $corpsJSON= file_get_contents('php://input');
      $data= json_decode($corpsJSON, TRUE);  
      if(isset($_GET['video'])){  
        $ControleurAvis->ajouterUnAvisUrlJSON($data); // Ajoute un avis id_video dans l'url
      } else {
        $ControleurAvis->ajouterUnAvisJSON($data); // Ajoute un avis doit fournir id_video dans corps
      }
      break;
    case'PUT':
      if(empty($_GET['id'])){
        echo json_encode("Id manquant");
      } else if(isset($_GET['id'])) {
        $corpsJSON= file_get_contents('php://input');
        $data= json_decode($corpsJSON, TRUE);
        $ControleurAvis->modifierUnAvisJSON($data);
      }
      break;
    case'DELETE':
      if(empty($_GET['id'])){
        echo json_encode("Id manquant");
      } else  if(isset($_GET['id'])) { // Supprimer un avis et non les avis d'une vidéo
        $ControleurAvis->supprimerUnAvisJSON($_GET['id']);
      }
      break;
    default:
  }
 
?>
