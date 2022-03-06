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
if(!empty($_POST)){
$status= $name= $avatar= $item_id= $cmt=$date='';
    if(isset($_POST['status'])){
        $status=$_POST['status'];
    }
    if(isset($_POST['name'])){
        $name=$_POST['name'];
        $name =str_replace('"','\\"',$name);
    }
    if(isset($_POST['avatar'])){
        $avatar=$_POST['avatar'];
        $avatar =str_replace('"','\\"',$avatar);
    }
    if(isset($_POST['item_id'])){
        $item_id=$_POST['item_id'];
    }
    if(isset($_POST['cmt'])){
        $cmt=$_POST['cmt'];
        $cmt =str_replace('"','\\"',$cmt);
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s');
    if($status!=''&&$name!=''&&$avatar!=''&&$item_id!=''&&$cmt!=''){
        
        $sql='insert into comment( member, avatar, id_item, content, time )
        value("'.$name.'","'.$avatar.'","'.$item_id.'","'.$cmt.'","'.$date.'")';
        execute($sql);
        header("Refresh:0");
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
    <title>Chi tiết</title>

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
  
<?php
$id=$_GET['id'];
$sql = "select * from item where id = '$id'";
$item_get = executeSingleResult($sql);
if($item_get==null){
  header('Location: prices.php');
        die();
}
?>
  <div class="container">
    <div class="card-detail">
        <div class="container-fluid">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    <div class="preview-pic tab-content">
                      <div class="tab-pane active"><img src="<?=fixUrl($item_get['image'],'../')?>" /></div>
                    </div>
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title"><?=$item_get['name']?></h3>
                    <p class="product-description"><?=$item_get['description']?></p>
                    <h4 class="price">current price: <span><?=number_format($item_get['price'])?></span> VNĐ</h4>
                    <p class="vote"><span id="tyms" style="font-weight: bold;"><?=$item_get['tym']?></span> of buyers enjoyed this product! </p>
                    <div class="action">
                        <button class="add-to-cart btn btn-default" type="button" onclick="addCart(<?=$item_get['id']?>,1)">add to cart</button>
                        <button class="like btn btn-default" type="button" onclick="tym(<?=$item_get['id']?>)"><span class="fa fa-heart"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
 <!--------- Comment ----------->

 <div class="container">
            <h3>Chi tiết sản phẩm</h3>
            <p>
            <?=$item_get['content']?>
            </p>
            <br><br>
            
<div class="row">
    <?php
    if($username_in!=''){
        $sql="select status,name,avatar from member where id='$username_in'";
        $member=executeSingleResult($sql);
        echo '
        <div class="col">
            <form method="post" onsubmit="return checkban()" name="cmtform">
                <div class="form-group">
                <input type="text" value="'.$member['status'].'" hidden="true" id="status" name="status">
                <input type="text" value="'.$member['name'].'" hidden="true" id="name" name="name">
                <input type="text" value="'.$member['avatar'].'" hidden="true" id="avatar" name="avatar">
                <input type="text" value="'.$item_get['id'].'" hidden="true" id="item_id" name="item_id">
                    <h3>Để lại bình luận ở đây</h3> <label for="message">Tin nhắn</label> 
                    <textarea name="cmt" rows="2" class="form-control" style="background-color: #fff;" ></textarea>
                </div>
                <div class=form-group>
                    <button class="btn btn-success" type="submit" style="width: 20%;">Gửi</button>
                </div>
            </form>
        </div>
        ';
    }
    ?></div>
    <!-- <div class="col">
        <form method="post">
            <div class="form-group">
                <h3>Để lại bình luận ở đây</h3> <label for="message">Tin nhắn</label> 
                <textarea name="msg" rows="2" class="form-control" style="background-color: #fff;"></textarea>
            </div>
            <div class=form-group>
                <button class="btn btn-success" type="submit" style="width: 20%;">Gửi</button>
            </div>
        </form>
    </div> -->
    <div class="row">
      <div class="panel panel-default widget">
          <div class="panel-heading">
              <span class="glyphicon glyphicon-comment"></span>
              <h3 class="panel-title">Những bình luận gần đây</h3>
          </div>
          <div class="panel-body">
              <ul class="list-group">


              <?php
                $sql="select * from comment where id_item = ".$item_get['id']." order by time desc limit 5";
                $cmt=executeResult($sql);
                if($cmt==null) echo'Không có bình luận nào!';
                else{ 
                foreach($cmt as $item){
                    echo'
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-2 col-sm-2">
                                    <img src="'.fixUrl($item['avatar'],'../').'" class="img-circle img-responsive" alt="img" style="max-width:50px"></div>
                                    <div class="col-lg-10 col-sm-10">
                                    <div>
                                        <!-- <a href="http://www.jquery2dotnet.com/2013/10/google-style-login-page-desing-usign.html">
                                            Google Style Login Page Design Using Bootstrap</a> -->
                                        <div class="mic-info">
                                        <strong>By:</strong> '.$item['member'].'<strong> on</strong> '.$item['time'].'
                                        </div>
                                    </div>
                                    <div class="comment-text">
                                    '.$item['content'].'
                                    </div>
                                </div>
                            </div>
                        </li>
                    ';
                }}
              ?>
              </ul>
              <!-- <a href="#" class="btn btn-primary btn-sm btn-block" role="button"><span class="glyphicon glyphicon-refresh"></span> More</a> -->
          </div>
      </div>
  </div>
 
</div> <!--------- End Comment ----------->

<br><br><br><br>
  <!--------- Footer ----------->
  <footer id="footer">
    <div class="container">
      <h3>Ryan</h3>
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
    function tym(id){     
        $.post('addcart.php',{
            'action':'tym',
            'id':id
        },function(data){
            $('#tyms').html(data)
        })
        
    }

        
</script>
</body>
</html>
