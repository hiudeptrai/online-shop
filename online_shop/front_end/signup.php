<<?php
session_start();
require_once('../db/dbhelper.php');
require_once('../funlib/funs.php');
$username_in='';
if (isset($_SESSION['username'])){
  $username_in=$_SESSION['username'];
  $sql = "select * from member where id = '$username_in'";
  $member_in = executeSingleResult($sql); 
  $user_avatar=$member_in['avatar'];
}

    if (isset($_POST['username'])){
  
    header('Content-Type: text/html; charset=UTF-8');
    $name       = addslashes($_POST['name']);
    $username   = addslashes($_POST['username']);
    $email      = addslashes($_POST['email']);
    $password   = addslashes($_POST['password']);
   
    if (!$name ||!$username || !$password || !$email )
    {
        echo "Vui lòng nhập đầy đủ thông tin. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
  
    //$password = md5($password);
    $sql="select id from member where id='$username'";
    $user=executeSingleResult($sql);
    if($user!=null){
      echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }      
     
    $sql="select id from member where email='$email'";
    $user=executeSingleResult($sql);
    if ($user!=null)
    {
        echo "Email này đã có người dùng. Vui lòng chọn Email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    
    $sql ='insert into member(id, pass, name, avatar, birth, email, phone, status )
        value("'.$username.'","'.$password.'","'.$name.'","photos/avt.png","","'.$email.'","","1")';
        $addmember=execute($sql);
    if ($addmember)
        {header('Location: signup_success.php');die();}
    else
        {echo "Có lỗi xảy ra trong quá trình đăng ký. <a href='signup.php'>Thử lại</a>";exit;}
    // header('Location: index.php');
    // die();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

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
<body style="background-color: #3598DC;">
    <!------- Header -------->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">ZUAN</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active" href="index.php">Trang chủ</a></li>
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
          <li><a href="contact.php">Liên hệ</a></li>
          <li><a href="blog.php">Tin tức</a></li>
          <li>
            <div class="dropdown">
              <a href="signin.php"  class="dropdown-toggle" data-toggle="dropdown"><?php
              if($username_in==''){
                echo '<img src="img/login_icon.png" id="login">';
              }else{
               echo' <img src="'.fixUrl($user_avatar,'../').'" id="login">';
              }
              ?></a>
              <div class="dropdown-menu">
              <?php
              if($username_in=='adminaccount'){
                echo'<a class="dropdown-item" href="../admin/member/index.php" style="color: black;">Trang quản trị</a>';
              }
                  if($username_in==''){
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
        <a href="shopping_cart.php" id="cart"><i class="fa fa-shopping-cart " style="font-size:24px;color:#fff;"></i></a>
      </nav>
    </div>
  </header><!-- End Header -->
  
    <div class="signup-form">
    <form action="" method="post" onsubmit="return checkForm()" name="myform">
		<h2>Đăng ký</h2>
		<p>Vui lòng điền vào form để tạo tài khoản !</p>
		<br>
        <div class="form-group">
        	<input type="text" class="form-control" name="name" placeholder="Họ và Tên" required="required">
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required="required">
        </div>
        
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Xác nhận mật khẩu" required="required">
        </div>        
        <div class="form-group">
			<label class="form-check-label"><input type="checkbox" required="required"> Tôi đồng ý <a href="#">Các điều khoản sử dụng</a> &amp; <a href="#">Chính sách bảo mật</a></label>
		</div>
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" style="color: #fff;">Đăng ký</button>
        </div>
    </form>
	<div class="hint-text">Bạn đã có tài khoản? <a href="signin.php">Đăng nhập ở đây</a></div>
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