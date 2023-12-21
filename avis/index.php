<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *'); 
  require_once'../controleurs/avis.php';
  $ControleurAvis = new ControleurAvis;


  // TODO trouver comment renommé URL au lieu de mettre ?id= ou id_video
  switch($_SERVER['REQUEST_METHOD']) {
    case'GET':
      if(isset($_GET['id'])) { 
        $ControleurAvis->afficherUnAvisJson(); //ok
      } else if(isset($_GET['video'])){
        $ControleurAvis->afficherTousAvisUnVideoJson();//ok
      } else {
        $ControleurAvis->afficherTousJson(); // ok
      }
      break;
    case'POST': //ok
      $corpsJSON= file_get_contents('php://input');
      $data= json_decode($corpsJSON, TRUE);  
      if(isset($_GET['video'])){  // TODO ?? Est-ce ok d'exiger le id_video dans l'URL ou pourrait être dans body?
        $ControleurAvis->ajouterUnAvisUrlJSON($data);
      } else {
        $ControleurAvis->ajouterUnAvisJSON($data);
      }
      break;
    case'PUT':
      if(isset($_GET['id'])) { // TODO trouver erreur il envoie ce message même si pas id dans l'url
        $corpsJSON= file_get_contents('php://input');
        $data= json_decode($corpsJSON, TRUE);
        $ControleurAvis->modifierUnAvisJSON($data);
      } else {
        echo json_encode("Id manquant");//ok
      }
      break;
    case'DELETE':
      if(isset($_GET['id'])) {
        $ControleurAvis->supprimerJSON($_GET['id']);
      }
      break;
    default:
  }
 
?>
