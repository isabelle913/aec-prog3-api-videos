<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Methods: POST, DELETE, PUT, OPTIONS");
  header('Access-Control-Allow-Headers: Content-Type');
  require_once'./controleurs/videos.php';
  $ControleurVideos = new ControleurVideos;

  switch($_SERVER['REQUEST_METHOD']) {
    case'GET':
      if(isset($_GET['id'])) { 
        $ControleurVideos->afficherUnJson($_GET['id']);
      } else{
        $ControleurVideos->afficherTousJson();
      }
      break;
    case'POST':
      $corpsJSON= file_get_contents('php://input');
      $data= json_decode($corpsJSON, TRUE); 
      $ControleurVideos->ajouterJSON($data);
      break;
    case'PUT':
      if(empty($_GET['id'])){
        echo json_encode("Id manquant");
      } else if (isset($_GET['id'])) {
        $corpsJSON= file_get_contents('php://input');
        $data= json_decode($corpsJSON, TRUE);
        $ControleurVideos->modifierJSON($data);
      }
      break;
    case'DELETE':
      if(empty($_GET['id'])){
        echo json_encode("Id manquant");
      } else if (isset($_GET['id'])) {
         $ControleurVideos->supprimerJSON($_GET['id']);;
      }
      break;
    default:
  }
 
?>

