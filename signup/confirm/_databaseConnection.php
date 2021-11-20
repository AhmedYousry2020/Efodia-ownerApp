<?php
class DB {

  private $pdo;
  
  public function __construct($host, $dbname, $username, $password) {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo = $pdo;
  }

  public function query($query, $params = array()) {
    $statement = $this->pdo->prepare($query);
    $dbResult = $statement->execute($params);

    if (explode(' ', $query)[0] == 'SELECT') {
      $dbResult = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $dbResult;
    }else{
      return $dbResult;
    }
    
  }

}
