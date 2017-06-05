<?php
  require_once '../../libs/Db.php';

  $query = $db->prepare("SELECT * FROM student");
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($results);
  ?>
