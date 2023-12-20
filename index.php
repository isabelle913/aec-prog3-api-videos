<?php
  header('Content-Type: application/json;');
  header('Access-Control-Allow-Origin: *'); // Permet d'être utilisé par des application * -> éventuellement spécifier qui pourra accéder
  require_once'./controleurs/videos.php';
  $ControleurVideos = new ControleurVideos;

  switch($_SERVER['REQUEST_METHOD']) {
    // TODO pourrait mettre tous les cas possible de get, catégories, avis....
    // categories/index.php
    // ou 
    // avis.php (possible de pas de sous-dossier car en lien avec les vidéos)
    case'GET':
      if(isset($_GET['id'])) { 
        $ControleurVideos->afficherUnJson();
      } else{
        $ControleurVideos->afficherTousJson();
      }
      break;
    case'POST':
      $corpsJSON= file_get_contents('php://input'); // Récupérer données dans body
      $data= json_decode($corpsJSON, TRUE); // 
      $ControleurVideos->ajouterJSON($data);
      break;
    case'PUT':
      if(isset($_GET['id'])) {
        $corpsJSON= file_get_contents('php://input');
        $data= json_decode($corpsJSON, TRUE);
        $ControleurVideos->modifierJSON($data);
      } else {
        echo json_encode("Id manquant");
      }
      break;
    case'DELETE':
      if(isset($_GET['id'])) {
        $ControleurVideos->supprimerJSON($_GET['id']);
      }
      break;
    default:
  }
 
?>

