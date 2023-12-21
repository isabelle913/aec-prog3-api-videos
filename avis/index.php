<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *'); 
  require_once'../controleurs/avis.php';
  $ControleurAvis = new ControleurAvis;

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
      if(isset($_GET['video'])){  // TODO ?? est-ce préférable de mettre dans l'url ou dans body?
        $ControleurAvis->ajouterUnAvisUrlJSON($data);
      } else {
        $ControleurAvis->ajouterUnAvisJSON($data);
      }
      break;
    case'PUT':
      if(isset($_GET['id'])) {
        $corpsJSON= file_get_contents('php://input');
        $data= json_decode($corpsJSON, TRUE);
        $ControleurAvis->modifierUnAvisJSON($data);
      } else {
        echo json_encode("Id manquant");//ok
      }
      break;
    case'DELETE':
      if(isset($_GET['id'])) {
        $ControleurAvis->supprimerUnAvisJSON();
      } else {
        echo json_encode("Id manquant"); //ok 
      }
      break;
    default:
  }
 
?>
