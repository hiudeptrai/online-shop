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
$sql='select * from category';
$categorylist=executeResult($sql);
$cat=$categorylist[0]['id'];
$cat_name=$categorylist[0]['name'];
if(isset($_GET['cat'])){
  $cat=$_GET['cat'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng giá</title>

    <link rel="icon" href="img/favicon.jpg">
    <link rel="apple-touch-icon" href="img/favicon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #F5F5F5;">
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">ZUAN</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="about.php">Giới thiệu</a></li>
          <li><a href="services.php">Dịch vụ</a></li>
		  <li class="dropdown"><a href="prices.php" class="active"><span>Sản phẩm</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
			<?php
		
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
  <div class="page-section">
	<div class="container-fluid">
		<div class="row">
			<!-- <div class="input-group mb-5" style="margin-left: 20vw;"> -->
      <form action="" method="get" class="input-group mb-5" style="margin-left: 20vw;">
      <input type="text" name="cat" value="<?=$cat?>" hidden="true" >
				<input type="text" class="form-control-sm" placeholder="Tìm kiếm" name="search" style="height:38px">
				<div class="input-group-append">
					<!-- <span class="input-group-text" id="basic-addon2"></input></span> -->
          <input class="input-group-text" type="submit" name="ok" value="search">
          <!-- class="fa fa-search" -->
          </form>
				<!-- </div> -->
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-3 blog-form">
				<h2><b class="blog-sidebar-title">DANH MỤC SẢN PHẨM</b></h2><br>
				  <div>&nbsp;</div>
				  <div>&nbsp;</div>
				  <?php
					foreach($categorylist as $item){
						echo'<a href="prices.php?cat='.$item['id'].'"><p class="blog-sidebar-list"><span class="list-icon"> > </span>'.$item['name'].'</p></a><hr />';
					}
				  ?>
			</div>
			<!--END  -->

      <?php
						$order=$isorder='';
            if(isset($_GET['order'])){
							$order=$_GET['order'];
						}
            $issearch='';
            if(isset($_REQUEST['ok'])){
              $search=addslashes($_GET['search']);
            }
            $sql="select * from item where category_id =$cat";
            if($order!=''){
              if($order=='increase'){
                $sql="select * from item where category_id =$cat order by price asc";
              }
              else if($order=='decrease'){
                $sql="select * from item where category_id =$cat order by price desc";
              }else{
                $sql="select * from item where category_id =$cat";
              }
            }
            if(!empty($search)){
              $sql="select * from item where category_id =$cat and name like '%$search%'" ;
            }
            
						$itemlist=executeResult($sql);

            $sql="select name from category where id =$cat";
            $cate=executeSingleResult($sql);
            $cat_name=$cate['name'];
      ?>
			<div class="col-lg-9 col-md-9 col-sm-9 col-9" style="padding-left: 30px;">
				<div class="row">
					<div class="col" style="font-size:30px;text-transform:uppercase;font-weight:bold;color: #0880e8;margin-bottom: 0;">
						<?=$cat_name?>
					</div>

					<div class="col">
            <form action="" method="get">
            <input type="text" name="cat" value="<?=$cat?>" hidden="true">
						<select class="form-control" style="background-color: #fff;" onchange="this.form.submit()" name="order">
            <?php
              if($order=='increase'){
                echo'<option value="">Mặc định</option>
                <option value="increase" selected>Giá tăng dần</option>
                <option value="decrease">Giá giảm dần</option>';
              }else if($order=='decrease'){
                echo'<option value="">Mặc định</option>
                <option value="increase">Giá tăng dần</option>
                <option value="decrease" selected>Giá giảm dần</option>';
              }else{
                echo'
                <option value="" selected>Mặc định</option>
							<option value="increase">Giá tăng dần</option>
							<option value="decrease">Giá giảm dần</option>';
              }
            ?>
						</select>
            </form>
					</div>
				</div>
				
				<div class="img-container">
            <?php
						foreach($itemlist as $item){
							echo'
							<div class="card">
								<div class="card-body text-center">
									<img src="'.fixUrl($item['image'],'../').'" class="product-image">
									<h5 class="card-title"><b>'.$item['name'].'</b></h5>
									<p class="card-text small">'.$item['description'].'</p>
									<p class="tags">Price '.number_format($item['price']).' VNĐ</p>
									<button  class="btn btn-primary" onclick="addCart('.$item['id'].',1)"><i class="fa fa-shopping-cart"></i> Add to cart</button>
									<a href="detail.php?id='.$item['id'].'" class="btn btn-danger">Chi tiết</a>
								</div>
							</div>
							';
						}

					?>	
				</div>
			</div>
		</div>
	</div>
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
  <script>
	  function addCart(id, num){     
        $.post('addcart.php',{
            'action':'cart',
            'id':id,
            'num':num
        },function(data){
            alert('Đã thêm vào giỏ hàng !');
        })
        
    }
  </script>
</body>
</html>
