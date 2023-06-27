<?php 
include('../config/connect.php');
  $res = json_decode(file_get_contents("php://input"));
  $data = array();

  if($res->action == "AllCategory"){
    $sql = "SELECT * FROM tb_categorie";
    $query = $con->query($sql);
    foreach($query as $row){
        $data[] = $row;
    }
    echo json_encode($data);
  }

  if($res->action == "addCategory"){
    $sql = "INSERT INTO tb_categorie(cat_name_categorie) VALUES('$res->category')";
    $query = $con->query($sql);
  }

  if($res->action == "deleteCategory"){
    $sql = "DELETE FROM tb_categorie WHERE cat_id = $res->id";
    $con->query($sql);
  }

  if($res->action == "editCategory"){
    $sql = "SELECT * FROM tb_categorie WHERE cat_id = $res->id";
    $query = $con->query($sql);
    foreach($query as $row){
        $data['cat_name_categorie'] = $row['cat_name_categorie'];
        $data['cat_id'] = $row['cat_id'];
    }
    echo json_encode($data);
  }

  if($res->action == "updateCategory"){
    $sql = "UPDATE `tb_categorie` SET `cat_name_categorie`='$res->category' WHERE cat_id = $res->id";
    $con->query($sql);
  }

  if($res->action == "getAllCounting"){
    $sql = "SELECT * FROM tb_counting_unit";
    $query = $con->query($sql);
    foreach($query as $row){
        $data[] = $row;
    }
    echo json_encode($data);
  }

  if($res->action == "addCounting"){
    $sql = "INSERT INTO `tb_counting_unit`(`ctu_name`) VALUES ('$res->counting')";
    $con->query($sql);
  }

  if($res->action == "editCounting"){
    $sql = "SELECT * FROM `tb_counting_unit` WHERE ctu_id = $res->id";
    $query = $con->query($sql);
    foreach($query as $row){
        $data['ctu_id'] = $row['ctu_id'];
        $data['ctu_name'] = $row['ctu_name'];
    }
    echo json_encode($data);
  }

  if($res->action == "updateCounting"){
    $sql = "UPDATE `tb_counting_unit` SET `ctu_name`='$res->counting' WHERE ctu_id = $res->id";
    $con->query($sql);
  }

  if($res->action == "deleteCounting"){
    $sql = "DELETE FROM tb_counting_unit WHERE ctu_id = $res->id";
    $con->query($sql);
  }


?>

