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
    <title>Giới thiệu</title>

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
  <!--------- Header -------->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">ZUAN</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a class="active" href="about.php">Giới thiệu</a></li>
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
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

   <!-------- About Us  --------->
  <div class="bg-white">
    <div class="container py-5">
      <div class="row h-100 align-items-center py-5">
        <div class="col-lg-6">
          <h1 class="display-4">Tin cậy - Tiện ích - Tận tình</h1>
          <p class="lead text-muted mb-0">ZUAN SOLUTIONS lấy khẩu hiệu Tin ậy - Tiện ích - Tận tình làm phương châm và kim chỉ nam cho mọi hoạt động của hệ thống nhằm hướng tới việc thỏa mãn mọi nhu cầu của khách hàng.</p><br>
          <p class="lead text-muted mb-0">Tầm nhìn của ZUAN SOLUTIONS là trở thành công ty chuyên cung cấp các giải pháp và dịch vụ Công Nghệ hàng đầu cả nước, định hướng phát triển ra khu vực và toàn cầu.</p><br>
          <p class="lead text-muted mb-0">Khách hàng của ZUAN SOLUTIONS luôn đạt lợi nhuận cao nhất từ các hoạt động đầu tư công nghệ chính nhờ vào các giải pháp chuyên ngành tiên tiến nhất, bề dày kinh nghiệm và năng lực chuyên môn vượt trội của đội ngũ nhân viên ZUAN SOLUTIONS.</p>

        </div>
        <div class="col-lg-6 d-none d-lg-block"><img src="https://bootstrapious.com/i/snippets/sn-about/illus.png" alt="" class="img-fluid"></div>
      </div>
    </div>
  </div>
  
  <div class="py-3 bg-about">
    <div class="container py-5">
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 order-2 order-lg-1"><i class="fa fa-bar-chart fa-2x mb-3 text-primary"></i>
          <h2>GIẢI PHÁP TỰ ĐỘNG ? QUẢN LÝ TỪ XA ? BẢO MẬT AN TOÀN ?</h2><br>
          <a href="contact.php" class="btn btn-light px-5 rounded-pill shadow-sm">Liên hệ chúng tôi</a>
        </div>
        <div class="col-lg-5 px-5 mx-auto order-1 order-lg-2"><img src="https://www.cmctssg.vn/wp-content/uploads/2021/09/file-366x280.png" alt="" class="img-fluid mb-4 mb-lg-0"></div>
      </div>
    </div>
  </div>
  
  <div class="bg-light py-0">
    <div class="container py-5">
      <div class="row mb-4">
        <div class="col-lg-5">
          <h2 class="display-4 font-weight-light">Thành viên</h2>
          <p class="font-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
      </div>
  
      <div class="row text-center">
        <!-- Team item-->
        <div class="col-xl-4 col-sm-6 mb-5">
          <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-4.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0">Nguyễn Tấn Tùng</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
          </div>
        </div>
        <!-- End-->
  
        <!-- Team item-->
        <div class="col-xl-4 col-sm-6 mb-5">
          <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-3.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0">Đặng Quang Hiệu</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
          </div>
        </div>
        <!-- End-->
  
        <!-- Team item-->
        <div class="col-xl-4 col-sm-6 mb-5">
          <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-2.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0">Nguyễn Lê Anh Khoa</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
          </div>
        </div>
        <!-- End-->
      </div>
    </div>

  <div id="motto1" class="motto1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center text-lg-start">
          <h1>"</h1>
          <p>Đội ngũ nhân viên chính là tài sản lớn nhất của doanh nghiệp. ZUAN SOLUTIONS chú trọng việc tuyển dụng
            các nhân viên có tính năng động và sáng tạo cao, đồng thời tạo động lực làm việc tốt cho nhân viên để có
            thể phát huy tối đa khả năng của mỗi người.
          </p>
        </div>
      </div>
    </div>
  </div>
  </div><!-- End About Us Section -->
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
