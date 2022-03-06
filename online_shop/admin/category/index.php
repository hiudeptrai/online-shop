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
	<title>Quản lí Danh mục</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="../../front_end/index.php">Trang khách</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="#" >Quản lý Danh mục</a>
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
			<a class="nav-link" href="../order">Quản lý Đơn hàng</a>
		</li>
    </ul>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Quản lý Danh mục</h2>
			</div>
			<div class="panel-body">
	<a href="add.php?action=add">
	<button class="btn btn-success" 
		style="margin-bottom:15px;">Thêm Danh mục</button>
	</a>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="50px">ID</th>
				<th width="350px">ẢNH</th>
				<th>Tên Danh mục</th>
				<th width="50px"></th>
				<th width="50px"></th>
			</tr>
		</thead>
		<tbody>
		<?php
$sql = 'select * from category';
$categorylist = executeResult($sql);
foreach($categorylist as $item){
		echo'<tr>
		<td>'.$item['id'].'</td>
		<td><img src="'.fixUrl($item['thumbnail'],'../../').'" style="max-width:300px" /></td>
		<td style="font-size:50px">'.$item['name'].'</td>
		<td>
		<a href="add.php?id='.$item['id'].'&action=edit">
		<button class="btn btn-warning">Sửa</button>
		</a>	
		</td>
		<td>
			<button class="btn btn-danger"
			onclick="deletecategory('.$item['id'].')">Xóa</button>
		</td>
		</tr>';
}
?>
		</tbody>
	</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function deletecategory(id){
			var option = confirm('Bạn có chắc chắn muốn xóa danh mục này không ?')
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
	</script>
</body>
</html>
