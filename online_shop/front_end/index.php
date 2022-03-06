<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>


    <link rel="icon" href="img/favicon.jpg">
    <link rel="apple-touch-icon" href="img/favicon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
</head>
<body>
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
              <a href="signin.php"  class="dropdown-toggle" data-toggle="dropdown">
              <?php
              if($username_in==''){
                echo '<img src="img/login_icon.png" id="login">';
              }else{
               echo' <img src="'.fixUrl($user_avatar,'../').'" id="login">';
              }
              ?>
              </a>
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
        <a href="shopping_cart.php" id="cart"><i class="fa fa-shopping-cart" style="font-size:24px;color:#fff;"></i></a>
      </nav>
    </div>
  </header><!-- End Header -->

  <!-------  Welcome -------->
  <div class="d-flex justify-cntent-center align-items-center welcome">
    <div class="welcome-container">
      <h2>Welcome to <span>ZUAN SOLUTIONS</span></h2>
      <p style="font-size:18px;font-weight:500;">Sứ mạng của chúng tôi là phát huy cao nhất năng lực của đội ngũ nhân tài và quy mô toàn cầu của ABC SOLUTIONS,
         chuyên cung cấp các dịch vụ và giải pháp công nghệ chuyên ngành thế hệ mới để đem lại các giá trị vượt trội 
         nhất cho khách hàng và nhân viên.</p>
    </div>
  </div><!-- End Welcome -->
<br><br>
  <!-------- Box -------->
  <div id="box" class="box">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="icon"><i class="fas fa-heartbeat"></i></div>
            <h4 class="title"><a href="">Sức khỏe</a></h4>
            <p class="description">Theo dõi các chỉ số về sức khoẻ từ xa, từ đó tăng cường sự kết nối giữa bác sĩ - bệnh nhân - thân nhân, hướng đến thành lập "Vùng An Toàn".</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="icon"><i class="fas fa-tractor"></i></div>
            <h4 class="title"><a href="">Giám sát</a></h4>
            <p class="description">Hệ thống giám sát các hoạt động . Hệ thống là sự kết hợp giữa các máy móc, giám sát hiệu suất làm việc, từ đó tính toán, điều khiển để đạt năng suất cao nhất.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="icon"><i class="fas fa-cogs"></i></div>
            <h4 class="title"><a href="">IoT</a></h4>
            <p class="description">Tư vấn, thiết kế hệ thống IoT, điều khiển tự động, giám sát từ xa trong mọi lĩnh vực sản xuất: nông nghiệp, công nghiệp tự động, giao thông vận tải...</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="icon"><i class="fab fa-watchman-monitoring"></i></div>
            <h4 class="title"><a href="">Quan trắc</a></h4>
            <p class="description">Hệ thống thu thập, lưu trữ và truyền dữ liệu quan trắc: bao gồm Quan trắc nước thải, quan trắc khí thải, quan trắc chất lượng nước...</p>
          </div>
        </div>

      </div>
    </div>
  </div><!-- End Box-->
<br><br>
  <!-------- Mission -------->
  <div id="mission" class="mission">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 align-items-stretch position-relative" style='background-image: url("img/business.jpg");'>
        </div>
        <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">
          <div class="content">
            <h3><strong>Sản phẩm - Giải pháp - Dịch vụ</strong></h3>
            <p>
              Zuan Solution tự hào là đơn vị tiên phong cung cấp các giải pháp - dịch vụ  dựa trên nền tảng CNTT tiên tiến 
              và dần khẳng định là nhà cung cấp giải pháp - dịch vụ tổng thể, toàn diện hàng đầu Việt Nam.
            </p>
          </div>
          <div class="accordion-list">
            <ul>
              <li>
                <span>01</span> Giải pháp và hạ tầng CNTT
              </li>
              <li>
                <span>02</span> Dịch vụ công nghệ và phần mềm
              </li>
              <li>
                <span>03</span> Giải pháp CNTT chuyên ngành
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Mission -->

  <!-------- Motto ----------->
  <div id="motto" class="motto">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center text-lg-start">
          <h1>"</h1>
          <p>"Hãy sống chứ đừng tồn tại".</p>
          <h4>Quang Hiệu</h4>
        </div>
      </div>

    </div>
  </div><!-- End Motto -->

  <!------- Partner -------->
  <div class="logo-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/09/hp.png" class="img-fluid" alt="HP logo"></a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/09/microsoft.png" class="img-fluid" alt="Microsoft logo"></a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/09/logo-dell-1.png" class="img-fluid" alt="Dell logo"></a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/09/oracle.png" class="img-fluid" alt="Oracle logo"></a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/11/20.png" class="img-fluid" alt="Eaton logo"></a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#"><img src="https://www.cmctssg.vn/wp-content/uploads/2017/09/hewllet-packard-enterprise.png" class="img-fluid" alt="Hewlett logo"></a>
            </div>
        </div>
    </div>
  </div>
  <!-- End Partner -->

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
</html>
