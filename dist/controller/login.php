<?php 
session_start();
include('../config/connect.php');
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $check = "SELECT * FROM tb_user WHERE username = '$username'";
    $query_check = $con->query($check);
    if($query_check->num_rows >= 1){
        $check_pass = "SELECT * FROM tb_user WHERE password = '$password'";
        $query_pass = $con->query($check_pass);
        if($query_pass->num_rows >= 1){
            $user = $con->query("SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");
            $row_user = $user->fetch_array();
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row_user['user_id'];
            $_SESSION['username'] = $row_user['username'];
            $_SESSION['password'] = $row_user['password'];
            echo 3;
        }else{
            echo 1;
        }
    }else{
        echo 0;
    }
}
?>