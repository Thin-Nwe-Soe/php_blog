<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location: login.php");
}
if($_SESSION['role'] != 1){
  header("Location: login.php");
}
if($_POST){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(empty($_POST['role'])){
      $role = 0 ;
    }
    else{
      $role = 1;
    }
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");

    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
      echo "<script>alert('Email duplicated')</script>";
    }else{
    $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
    $result = $stmt->execute(
      array(':name'=>$name,':email'=>$email,':password'=>$password,':role'=>$role)
    );
    if($result){
      echo "<script>alert('Successfully Added');window.location.href='user_list.php';</script>";
    }
  
}
}
include 'header.php';
?>
 <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="user_add.php" method="post">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" value="" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" value="" required>
                </div>
                <div>
                  <label>Admin</label>
                  <input type="checkbox" name="role" value="1">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                  <a href="user_list.php" class="btn btn-warning">Back</a>
                </div>
              </div>
            </div>
            <!-- /.card -->

            
             
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php 
  include 'footer.html';
   ?>

  
