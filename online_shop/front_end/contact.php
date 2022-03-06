<?php
session_start();
require_once('../db/dbhelper.php');
require_once('../funlib/funs.php');
$member_name=$member_phone=$member_email='';
if (isset($_SESSION['username'])){
  $member_name=$_SESSION['username'];
  $sql = "select email, phone,avatar from member where id = '$member_name'";
  $member_in = executeSingleResult($sql);
  $member_phone=$member_in['phone'];
  $member_email=$member_in['email']; 
  $user_avatar=$member_in['avatar'];
}


if(isset($_POST)){
  $txtName=$txtEmail=$txtPhone=$txtMsg='';
  if(!empty($_POST)){   
      if(isset($_POST['txtName'])){
          $txtName=$_POST['txtName'];
          $txtName =str_replace('"','\\"',$txtName);
      }
      if(isset($_POST['txtEmail'])){
        $txtEmail=$_POST['txtEmail'];
        $txtEmail =str_replace('"','\\"',$txtEmail);
      }
      if(isset($_POST['txtPhone'])){
        $txtPhone=$_POST['txtPhone'];
        $txtPhone =str_replace('"','\\"',$txtPhone);
      }
      if(isset($_POST['txtMsg'])){
        $txtMsg=$_POST['txtMsg'];
        $txtMsg =str_replace('"','\\"',$txtMsg);
      }
      date_default_timezone_set('Asia/Ho_Chi_Minh');
      $date = date('Y-m-d H:i:s');
      $sql ='insert into contact(name, phone, email, content, time)
      value("'.$txtName.'","'.$txtPhone.'","'.$txtEmail.'","'.$txtMsg.'","'.$date.'")';
      execute($sql);
      header('Location: contact_success.php');
      die();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>

    <link rel="icon" href="img/favicon.jpg">
    <link rel="apple-touch-icon" href="img/favicon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">ZUAN</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="about.php">Giới thiệu</a></li>
          <li><a href="services.php">Dịch vụ</a></li>
          <li class="dropdown"><a href="prices.php"><span>Sản phẩm</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <?php
            $sql='select * from category';
            $categorylist=executeResult($sql);
            foreach($categorylist as $item){
              echo'<li><a href="prices.php?cat='.$item['id'].'">'.$item['name'].'</a></li>';
            }
            ?>
            </ul>
          </li>
          <li><a class="active" href="contact.php">Liên hệ</a></li>
          <li><a href="blog.php">Tin tức</a></li>
          <li>
            <div class="dropdown">
              <a href="signin.php"  class="dropdown-toggle" data-toggle="dropdown">
              <?php
              if($member_name==''){
                echo '<img src="img/login_icon.png" id="login">';
              }else{
               echo' <img src="'.fixUrl($user_avatar,'../').'" id="login">';
              }
                ?>
              </a>
              <div class="dropdown-menu">
              <?php
              if($member_name=='adminaccount'){
                echo'<a class="dropdown-item" href="../admin/member/index.php" style="color: black;">Trang quản trị</a>';
              }
                  if($member_name==''){
                    echo'
                    <a class="dropdown-item" href="signup.php" style="color: black;">Đăng ký</a>
                    <a class="dropdown-item" href="signin.php" style="color: black;">Đăng nhập</a>
                    ';
                  }else{
                    echo '
                    <a class="dropdown-item" href="information.php" style="color: black;">Thay đổi thông tin cá nhân</a>
                    <a class="dropdown-item" href="logout.php" style="color: black;">Đăng xuất</a>
                    ';
                  }

                ?>
              </div>
            </div>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
        <a href="shopping_cart.php" id="cart"><i class="fa fa-shopping-cart" style="font-size:24px;color:#fff;"></i></a>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  
  <div class="container contact-form">
    <div class="contact-image">
        <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
    </div>
    <form method="post" onsubmit="return checkForm3()" name="myform3">
        <h3>Gửi tin nhắn cho chúng tôi</h3>
       <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="txtName" class="form-control" placeholder="Tên" value="<?=$member_name?>">
                </div>
                <div class="form-group">
                    <input type="text" name="txtEmail" class="form-control" placeholder="Email" value="<?=$member_email?>">
                </div>
                <div class="form-group">
                    <input type="text" name="txtPhone" class="form-control" placeholder="Số điện thoại" value="<?=$member_phone?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <textarea name="txtMsg" class="form-control" placeholder="Nội dung" style="width: 100%; height: 150px;"></textarea>
                </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-danger">Gửi</button>
          </div>
        </div>

    </form>
</div>


  <!--------- Footer ----------->
  <footer id="footer">
    <div class="container">
      <h3>Zuan</h3>
      <p>Các lĩnh vực hoạt động của chúng tôi: Mua bán thiết bị, máy móc; Xuất bản phần mềm; Thiết kế phần cứng mạch điện ứng dụng...</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>Zuan</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://www.facebook.com/charlesdephys">Zuan</a>
      </div>
    </div>
  </footer><!-- End Footer -->
  <script src="main.js"></script>
</body>
</html>
