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
	<title>Quản lí Sản phẩm</title>
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
			<a class="nav-link active" href="#">Quản lý Thành viên</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../contact">Quản lý Liên hệ</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../order">Quản lý Đơn hàng</a>
		</li>
    </ul>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Quản lý Thành viên</h2>
			</div>
			<div class="panel-body">
	<a href="add.php?action=add">
	<button class="btn btn-success" 
		style="margin-bottom:15px;">Thêm Thành viên</button>
	</a>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
                <th width="300px">Tên thành viên</th>
				<th>Ảnh đại diện</th>
				<th width="110px"></th>
				<th width="110px"></th>
				<th width="50px"></th>
				<th width="50px"></th>
			</tr>
		</thead>
		<tbody>
		<?php

		$sql='select count(id) as number from member';
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
		$sql = 'select * from member limit '.$index.','.max_slot.'';
		$memberlist = executeResult($sql);
		foreach($memberlist as $item){
			if($item['id']!=$username_in){ 
			if($item['status']=='0'){
				echo'<tr>
				<td>'.$item['name'].'<span style="color:red"> (Banned)</span></td>';
			}else{
				echo'<tr>
				<td>'.$item['name'].'</td>';
			}
				echo'
				<td><img src="'.fixUrl($item['avatar'],'../../').'" style="max-width:100px" /></td>';
			if($item['status']=='0'){
				echo'<td>
						<button class="btn btn-success"
						onclick="unban(\''.$item['id'].'\')">Bỏ cấm</button>
					</td>';
			}else{
				echo'<td>
						<button class="btn btn-danger"
						onclick="ban(\''.$item['id'].'\')">Cấm</button>
					</td>';
			}
				echo'
				<td>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#member'.$item['id'].'">
					Chi tiết</button>
				</td>
				<td>
					<a href="add.php?id='.$item['id'].'&action=edit">
						<button class="btn btn-warning">Sửa</button>
					</a>	
				</td>
				<td>
					<button class="btn btn-danger"
					onclick="deleteitem(\''.$item['id'].'\')">Xóa</button>
				</td>
				</tr>';

			echo'
			<div class="modal" id="member'.$item['id'].'">
			<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Thông tin thành viên</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
				Tên thành viên: '.$item['name'].'<br>
				ID:'.$item['id'].'<br>
				Mật khẩu: '.$item['pass'].'<br>
				Avatar:<br>
				<img src="'.fixUrl($item['avatar'],'../../').'" style="max-width:200px" /><br>
				Ngày sinh: '.$item['birth'].'<br>
				Email: '.$item['email'].'<br>
				Số điện thoại: '.$item['phone'].'<br>';
				if($item['status']==0){
					echo'Trạng thái: Đang bị cấm';
				}else{
					echo'Trạng thái: Không bị cấm';
				}
			echo'
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				
			</div>
			</div>
		</div>';
			}
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
		function deleteitem(id){
			var option = confirm('Bạn có chắc chắn muốn xóa tài khoản này không ?')
			if(!option){
				return;
			}
			console.log(id)
			$.post('ajax.php',{
				'id': id,
				'action':'delete'
			},function(data){
				location.reload()
			})

		}
        function ban(id){
			console.log('ban'+id);
			var option = confirm('Bạn có chắc chắn muốn cấm người này không ?')
			if(!option){
				return;
			}
			console.log(id)
			$.post('ajax.php',{
				'id': id,
				'action':'ban'
			},function(data){
				location.reload()
			})
		}
        function unban(id){
			console.log('unban'+id);
			var option = confirm('Bạn có chắc chắn muốn bỏ cấm người này không ?')
			if(!option){
				return;
			}
			console.log(id)
			$.post('ajax.php',{
				'id': id,
				'action':'unban'
			},function(data){
				location.reload()
			})
		}
	</script>
</body>
</html>