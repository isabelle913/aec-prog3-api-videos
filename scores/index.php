<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Methods: POST, DELETE, PUT, PATCH, OPTIONS");
  header('Access-Control-Allow-Headers: Content-Type');
  require_once'./controleurs/scores.php';
  $ControleurScores = new ControleurScores;

  switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if (isset($_GET['id'])) { 
         $ControleurScores->afficherScore($_GET['id']);
      }
      break;
    case'PATCH':
       if(empty($_GET['video'])){
        echo json_encode("Id-video manquant");
      } else if(empty($_GET['action'])){
        echo json_encode("Action manquante");
      } else if($_GET['action'] === 'add'){
        $ControleurScores->increaseScore($_GET['video']);
      } else if($_GET['action'] === 'lower'){
        $ControleurScores->decreaseScore($_GET['video']);
      } else {
        echo json_encode("URL invalide");
      }
      break;
    default:
  }
 
?>