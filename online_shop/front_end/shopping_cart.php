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
  $name=$phone=$address=$date=$list=$transport=$shipfee='';
  if(isset($_POST['name'])){
  $name=$_POST['name'];
  $name =str_replace('"','\\"',$name);
  }
  if(isset($_POST['ship_choi'])){
    $shipfee=$_POST['ship_choi'];
    if($shipfee==30000) $transport='Vận chuyển thường';
    else $transport='Vận chuyển nhanh';
  }
  if(isset($_POST['address'])){
    $address=$_POST['address'];
    $address =str_replace('"','\\"',$address);
  }
  if(isset($_POST['phone'])){
    $phone=$_POST['phone'];
    $phone =str_replace('"','\\"',$phone);
  }
  if(isset($_POST['sum_total'])){
    $total=$_POST['sum_total'];
  }
  if(isset($_POST['list_order'])){
    $list=$_POST['list_order'];
    $list =str_replace('"','\\"',$list);
  }
  date_default_timezone_set('Asia/Ho_Chi_Minh');
  $date = date('Y-m-d H:i:s');
  if(!empty($name)&&!empty($phone)){
  $sql='insert into purchase(name, phone, address, time, list, transport, fee, status)
  value("'.$name.'","'.$phone.'","'.$address.'","'.$date.'","'.$list.'","'.$transport.'","'.$total.'","1")';
  execute($sql);

  header('Location: purchase_success.php');
        die();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

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
<body onload="gettotal()">
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
          <li><a class="active" href="blog.php">Tin tức</a></li>
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

  <br><br><br><br><br><br><br>
  <div class="card-cart">
    <div class="row">
        <div class="col-md-8 cart">
            <div class="title">
                <div class="row">
                    <div class="col">
                        <h4><b>Đơn hàng của bạn</b></h4>
                    </div>
                    <div class="col align-self-center text-right text-muted">
                      <span class="count_item"><?php if(empty($_SESSION['cart'])) echo'0';
                    else echo count($_SESSION['cart']); ?></span> items
                  </div>
                </div>
            </div>
            <div id="list_item">
            <?php
            $sum_cost=0;
            $cart=[];
            if(!empty($_SESSION['cart'])){
              $cart=$_SESSION['cart'];
            }
            for($i=0;$i<count($cart);$i++){
              $gia=intval($cart[$i]['num'])*intval($cart[$i]['price']);
              $sum_cost=$sum_cost+$gia;
              echo'
              <div class="row border-top ">
                <div class="row main align-items-center">
                    <div class="col-2"><img class="img-fluid imgx" src="'.fixUrl($cart[$i]['image'],'../').'"></div>
                    <div class="col">
                    <div class="row text-muted"></div>
                        <div class="row">'.$cart[$i]['name'].'</div>
                    </div>
                    <div class="col"> <button class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',1)">-</button>
                    <span   style="color: black;">'.$cart[$i]['num'].'</span>
                    <button   class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',1)">+</button> </div>
                    <div class="col">'.number_format($gia).' VNĐ<button class="close" onclick="deleteitem('.$cart[$i]['id'].')">&#10005;</button></div>
                </div>
            </div>
              ';
            }
            ?>
            </div>
            
            <div class="back-to-shop"><a href="prices.php">&leftarrow;<span class="text-muted">Tiếp tục mua hàng</span></a></div>
        </div>
        <div class="col-md-4 summary">
            <div>
                <h5><b>Thành tiền</b></h5>
            </div>
            <hr>
            <div class="row">
                <div class="col" style="padding-left:0;">ITEMS: <span class="count_item">
                <?php if(empty($_SESSION['cart'])) echo'0';
                    else echo count($_SESSION['cart']); ?></span>
              </div>
                <div class="col text-right"><span id="sum_cost"><?=number_format($sum_cost)?></span> VNĐ</div>
            </div>
            <form name="myform2" onsubmit="return checkForm3()" method="post">
                <p>Hình thức vận chuyển</p> <select onchange="gettotal()" id="ship_choi" name="ship_choi">
                    <option class="text-muted" value="30000" selected>Vận chuyển thường: 30,000 VNĐ</option>
                    <option class="text-muted" value="50000">Vận chuyển nhanh: 50,000 VNĐ</option>
                </select>
                <p>TÊN</p> <input type="text" class="code" id="name" name="name" placeholder="Nhập tên" required="required">
                <p>ĐỊA CHỈ</p> <input type="text" class="code" id="address" name="address" placeholder="Nhập địa chỉ" required="required">
                <p>SỐ ĐIỆN THOẠI</p> <input type="text" class="code" id="phone" name="phone" placeholder="Nhập số điện thoại">
            <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                <div class="col">Tổng cộng</div>
               <input id="sum_total" name="sum_total" hidden="true">
               <input id="list_order" name="list_order" hidden="true">
                <div class="col text-right"><span id="total"></span> VNĐ</div>
            </div> <button type="submit" class="btn btn-dark" style="width: 100%;" onclick="deletecart()">ĐẶT HÀNG</button>
            </form>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br>

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
            $('#list_item').html(data);
            getcount();
            getsum();
        })
    }
    function deleteitem(id){     
        $.post('addcart.php',{
            'action':'deleteitem',
            'id':id
        },function(data){
            $('#list_item').html(data);
            getcount();
            getsum();
        }) 
    }
    function getcount(){     
        $.post('addcart.php',{
            'action':'getcount'
        },function(data){
            $('.count_item').html(data);
        }) 
    }
    function getsum(){     
        $.post('addcart.php',{
            'action':'getsum'
        },function(data){
            $('#sum_cost').html(data);
            gettotal();
        })   
    }
    function gettotal(){ 
      var val=$('#ship_choi').val();
        $.post('addcart.php',{
            'action':'gettotal',
            'fee':val
        },function(data){
            $('#total').html(data);
            document.getElementById('sum_total').value = data;
        }) 
        getlist();  
    }
    function getlist(){     
        $.post('addcart.php',{
            'action':'getlist'
        },function(data){
          document.getElementById('list_order').value = data;
        }) 
    }
    function deletecart(){
      $.post('addcart.php',{
          'action':'deletecart'})
    }
    // function order(){
    //   getlist();
    //   checkForm2();
    //   var shipfee=$('#ship_choi').val();
    //   var name=$('#name').val();
    //   var address=$('#address').val();
    //   var phone=$('#phone').val();
    //   var total=$("#total span").text();
     
    //     $.post('shopping_cart.php',{
    //         'shipfee':shipfee,
    //         'name':name,
    //         'address':address,
    //         'phone':phone,
    //         'total':total,
    //         'list':list
    //     },function(data){
    //       $.post('addcart.php',{
    //         'action':'delete'
    //     }) 
    //     })  
    // }

    function checkForm2(){
  var sdt = document.forms["myform2"]["phone"].value;
  var name = document.forms["myform2"]["name"].value;
  var address = document.forms["myform2"]["address"].value;
  if(sdt.length != 10) {
    alert("SĐT không đúng định dạng !!");
    return false;
  }
  if(name.length < 1) {
    alert("Vui lòng nhập tên !!");
    return false;
  }
  if(address.length < 1) {
    alert("Vui lòng nhập địa chỉ !!");
    return false;
  }

  return true;
}
    

  </script>
</body>
</html>
