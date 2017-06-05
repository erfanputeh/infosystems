<?php
if(isset($_GET['id'])){
  $target_dir = "D:/xampp/htdocs/infosystems/img/personal/";
  unlink($target_dir.$_GET['images']);//ลบรูป

  $query = $db->prepare("DELETE FROM personal WHERE personal.id_personal= :id");
  $result = $query->execute([
    "id" => $_GET['id'],
  ]);
  if($result){
    echo "<script>
            alert('Delete Success!');
            window.location = 'home.php?file=personal/index';
          </script>";
  }else{
    // window.location = 'home.php?file=personal/index';
    echo "window.location = 'home.php?file=personal/index';";
  }
}
// echo $_GET['id'];
?>
