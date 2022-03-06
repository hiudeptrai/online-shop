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
  $user_name=$member_in['name'];
  $user_phone=$member_in['phone'];
  $user_email=$member_in['email'];
  $user_pass=$member_in['pass'];
  $sql="select (MONTH(birth)) AS month , (DAY(birth)) AS day , (YEAR(birth)) AS year from member where id = '$username_in'";
  $birth=executeSingleResult($sql);
  $birth_day=$birth['day'];
  $birth_month=$birth['month'];
  $birth_year=$birth['year'];
}else{header('Location: index.php');die();}
if(!empty($_FILES)){

    $thumbnail= moveavt('thumbnail','../');
    $sql="update member set avatar= '$thumbnail' where 
    id = '$username_in'";
    execute($sql);
    header("Refresh:0");
    die();
}

if(!empty($_POST)){
  if(isset($_POST['action'])){ 
  if($_POST['action']=='info'){
    $name=$email=$phone=$day=$month=$year='';
    if(!empty($_POST)){   
        if(isset($_POST['name'])){
            $name=$_POST['name'];
            $name =str_replace('"','\\"',$name);
        }
        if(isset($_POST['email'])){
          $email=$_POST['email'];
          $email =str_replace('"','\\"',$email);
        }
        if(isset($_POST['phone'])){
          $phone=$_POST['phone'];
          $phone =str_replace('"','\\"',$phone);
        }
        if(isset($_POST['day'])){
          $day=$_POST['day'];
        }
        if(isset($_POST['month'])){
          $month=$_POST['month'];
        }
        if(isset($_POST['year'])){
          $year=$_POST['year'];
        }
        $dateint = mktime(0, 0, 0, $month, $day, $year);
        $date = date('Y-m-d', $dateint);
      $sql="update member set name = '$name',phone = '$phone', email = '$email', birth = '$date' where 
      id = '$username_in'";
        execute($sql);
        header('Location: info_success.php');
        die();
      }
    }
    if($_POST['action']=='pass'){
      if(isset($_POST['old_password'])){
          $old_pass=$new_pass=$confirm_pass=$wrong='';
          if(isset($_POST['old_password'])){
            $old_pass=$_POST['old_password'];
          }
          if(isset($_POST['password'])){
            $new_pass=$_POST['password'];
          }
          if(isset($_POST['confirm_password'])){
            $confirm_pass=$_POST['confirm_password'];
          }
          if($old_pass!=$user_pass){
            alert("Bạn đã nhập sai mật khẩu cũ !");
            $wrong='wrong';
          }
          if(strlen($new_pass)<4){
            alert("Mật khẩu phải có tối thiểu 4 kí tự !");
            $wrong='wrong';
          }
          if($new_pass!=$confirm_pass){
            alert("Mật khẩu xác nhận sai !");
            $wrong='wrong';
          }
          if($wrong==''){
            $sql="update member set pass= '$new_pass' where 
            id = '$username_in'";
            execute($sql);
            alert("Thay đổi mật khẩu thành công !");
          }

      }
    }
  }
}



  function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>

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
<br><br><br>
  <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-5 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" src="<?=fixUrl($user_avatar,'../')?>" style="max-width:300px">
            <br><span><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#avatar<?=$username_in?>">
					Ảnh mới</button></span>
          <br><span><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pass<?=$username_in?>">
				Mật khẩu mới</button></span><br>
            <span class="text-black-50"><strong>ID: </strong><?=$username_in?></span><span> </span></div>
        </div>
        <!-- Modal Avatar -->
        <div class="modal" id="avatar<?=$username_in?>">
          <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Thay đổi ảnh đại diện</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                      <div class="form-group">
                              <label for="thumbnail">Hình ảnh:</label>
                              <input required="true" type="file" accept=".png, .jpg, 
                              .jpeg, .gif, .bmp, .tif, .jfif, .tiff|image/*"
                              class="form-control" id="thumbnail" name="thumbnail"  > 
                      </div>   
                      <button type="submit" class="btn btn-success">Lưu</button>
                    </form>
                </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            
          </div>
          </div>
		    </div>

        <!-- Modal Password -->
        <div class="modal" id="pass<?=$username_in?>">
          <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Thay đổi mật khẩu</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
              <div class="modal-body">
                  <form method="post" enctype="multipart/form-data">
                    <input type="text" name="action" value="pass" hidden="true">
                    <div class="form-group">
                      <input type="password" class="form-control" name="old_password" placeholder="Mật khẩu cũ" required="required">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Xác nhận mật khẩu" required="required">
                    </div>      
                      <button type="submit" class="btn btn-success">Lưu</button>
                    </form>
                </div>
              
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
		      </div>
              <!-- End modal -->

        <div class="col-md-7 border">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Thông tin tài khoản</h4>
                </div>
                <form method="post" action="">
                <input type="text" name="action" value="info" hidden="true">
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Họ & Tên</label>
                          <input type="text" name="name" class="form-control" placeholder="Nhập họ tên" value="<?=$user_name?>"></div>
                        <div class="col-md-12"><label class="labels">Số điện thoại</label>
                          <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="<?=$user_phone?>"></div>                      
                        <div class="col-md-12"><label class="labels">Email</label>
                          <input type="text" name="email" class="form-control" placeholder="Nhập email" value="<?=$user_email?>"></div>
                    </div>
                    <div class="row mt-3"><div class="col-md-12"><label class="labels">Ngày sinh</label></div></div>
                    <div class="row mt-3">
                        <div class="col-md-4"> 
                        <select name="day">
                            <option value="0">Ngày</option>
                              <?php
                                for($i=1;$i<=31;$i++){
                                  if($i==$birth_day) echo'<option value="'.$i.'" selected>'.$i.'</option>';
                                  else echo'<option value="'.$i.'">'.$i.'</option>';
                                }
                              ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="month">
                                <option value="0">Tháng</option>
                                <?php
                                for($i=1;$i<=12;$i++){
                                  if($i==$birth_month) echo'<option value="'.$i.'" selected>'.$i.'</option>';
                                  else echo'<option value="'.$i.'">'.$i.'</option>';
                                }
                              ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="year">
                                <option value="0">Năm</option>
                                <?php
                                for($i=1930;$i<=2021;$i++){
                                  if($i==$birth_year) echo'<option value="'.$i.'" selected>'.$i.'</option>';
                                  else echo'<option value="'.$i.'">'.$i.'</option>';
                                }
                              ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary" type="submit">Cập nhật</button></div>
                </form>
            </div>
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
</body>
</html>
