<?php
session_start();
require_once('../../db/dbhelper.php');
require_once('../../funlib/funs.php');
$username_in='';
if (isset($_SESSION['username'])){
  $username_in=$_SESSION['username'];
  if($username_in!='adminaccount'){
	header('Location: index.php');
	die();
  }
}else{
	header('Location: index.php');
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quản lí Đơn hàng</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="../../front_end/index.php">Trang khách</a>
		</li>
    	<li class="nav-item">
			<a class="nav-link" href="../category" >Quản lý Danh mục</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../item">Quản lý Sản phẩm</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../member">Quản lý Thành viên</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../contact">Quản lý Liên hệ</a>
		</li>
        <li class="nav-item">
			<a class="nav-link active" href="#">Quản lý Đơn hàng</a>
		</li>
    </ul>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Quản lý Đơn hàng</h2>
			</div>
			<div class="panel-body">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
                <th width="200px">Mã đơn hàng</th>
				<th >Tên người nhận</th>
				<th width="200px">Ngày tạo đơn hàng</th>
				<th width="150px">Trạng thái</th>
				<th width="150px">Đơn hàng</th>
				<th width="100px"></th>
			</tr>
		</thead>
		<tbody>
		<?php

		$sql='select count(id) as number from purchase';
		$result = executeResult($sql);
		$number=0;
		if($result!=null&&count($result)>0){
			$number=$result[0]['number'];
		}
		define('max_slot', '10');
		$pages = ceil($number/max_slot);
		$current_page=1;
		if(isset($_GET['page'])){
			$current_page=$_GET['page'];
		}
		$index=($current_page-1)*max_slot;
		$sql = 'select * from purchase order by (case status when 0 then 100 else 1 end) asc, time desc limit '.$index.','.max_slot.'';
		$orderlist = executeResult($sql);
		foreach($orderlist as $item){
			if($item['status']=='0'){
				echo'<tr>
				<td>'.$item['id'].'</td>
				<td>'.$item['name'].'</td>
				<td>'.$item['time'].'</td>
                <td>
					<button class="btn btn-primary">Đã xử lý</button>
				</td>';
			}else{
				echo'<tr style="color:red">
				<td>'.$item['id'].'</td>
				<td >'.$item['name'].'</td>
				<td >'.$item['time'].'</td>
                <td>
					<button class="btn btn-success" onclick="process('.$item['id'].')">Chờ xử lý</button>
				</td>';
			}
			echo'
			<td>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order'.$item['id'].'">
				Chi tiết</button>
			</td>
			<td>
				<button class="btn btn-danger"
				onclick="deleteorder('.$item['id'].')">Xóa</button>
			</td>
			</tr>';

			echo'
			<div class="modal" id="order'.$item['id'].'">
			<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Thông tin đơn hàng '.$item['id'].'</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
				<strong>Tên người nhận :</strong> '.$item['name'].'<br>
				<strong>Số điện thoại :</strong> '.$item['phone'].'<br>
				<strong>Địa chỉ :</strong> '.$item['address'].'<br>
				<strong>Hình thức vận chuyển : </strong>'.$item['transport'].'<br>
				<strong>Ngày tạo đơn :</strong> '.$item['time'].'<br>
				<strong>Danh sách đơn hàng : </strong><br>
				'.$item['list'].' 
				<strong>Tổng tiền : </strong>'.$item['fee'].' VNĐ <br>
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				
			</div>
			</div>
		</div>';
		}


		?>
			<span></span>
		</tbody>
	</table>
			</div>
		</div>
		<div class="row">
			<ul class="pagination" style="margin-left:15px">
				<?php
				if($current_page>1){echo '<li class="page-item"><a class="page-link" href="index.php?page='.($current_page-1).'"><</a></li>';}	
				if($pages<6)	{ 		
				for($i=1;$i<=$pages;$i++){
					if($i==$current_page){ 
						echo '<li class="page-item active"><a class="page-link" href="index.php?page='.$i.'" >'.$i.'</a></li>';
					}else{
						echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
					}
					}
				}else{
					if(($current_page-2)>1) {echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';}
					if($current_page<3){$begin=1;$end=5;}
					else if($current_page>$pages-2){$begin=$pages-4;$end=$pages;}
					else {$begin=$current_page-2;$end=$current_page+2;}
					for($i=$begin;$i<=$end;$i++){
						if($i==$current_page){ 
							echo '<li class="page-item active"><a class="page-link" href="index.php?page='.$i.'" >'.$i.'</a></li>';
						}else{
							echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
						}
					}
					if(($current_page+2)<$pages) {echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';}
				}

				if($current_page<$pages){echo '<li class="page-item"><a class="page-link" href="index.php?page='.($current_page+1).'">></a></li>';}
				?>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		function deleteorder(id){
			var option = confirm('Bạn có chắc chắn muốn xóa đơn hàng này không ?')
			if(!option){
				return;
			}
			$.post('ajax.php',{
				'id': id,
				'action':'delete'
			},function(data){
				location.reload()
			})
		}
        function process(id){
			var option = confirm('Bạn đã xử lý đơn hàng này chưa ?')
			if(!option){
				return;
			}
			console.log(id)
			$.post('ajax.php',{
				'id': id,
				'action':'process'
			},function(data){
				location.reload()
			})
		}
	</script>
</body>
</html>