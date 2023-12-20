<?php
class Db  {
  public static $username = 'root';
  public static $password = 'mysql';
  public static $host = 'localhost';
  public static $database = 'app-video';

    /***
     * Fonction permettant de se connecter à la base de données
     */
    static function connecter() {
        
        $mysqli = new mysqli(Db::$host, Db::$username, Db::$password, Db::$database);

        // Vérifier la connexion
        if ($mysqli -> connect_errno) {
            echo "Échec de connexion à la base de données MySQL: " . $mysqli -> connect_error;   // Pour fins de débogage
            exit();
        } 

        return $mysqli;
    }




}
?>