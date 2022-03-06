<?php
require_once('../../db/dbhelper.php');
require_once('../../funlib/funs.php');
$id=$pass=$name=$avatar=$birth=$email=$phone=$status=$action='';


if(!empty($_POST)){  
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    } 
    if(isset($_POST['pass'])){
        $pass=$_POST['pass'];
    } 
    if(isset($_POST['name'])){
        $name=$_POST['name'];
        $name =str_replace('"','\\"',$name);
    }
    
    $avatar= moveFile('avatar','../../');

    if(isset($_POST['avatar'])){
        $avatar=$_POST['avatar'];
    }
    if(isset($_POST['birth'])){
        $birth=$_POST['birth'];
    }
    if(isset($_POST['email'])){
        $email=$_POST['email'];
    }
    if(isset($_POST['phone'])){
         $phone=$_POST['phone'];
    }
    if(isset($_POST['status'])){
        $status=$_POST['status'];
   }
   if(isset($_POST['action'])){
    $action=$_POST['action'];
}

//    if(empty($id)||empty($name)||empty($image)||empty($price)||empty($category_id)){
//        echo('a');
//        die();
//     header('Location: index.php');
//     die();
//    }

    if($action =='add'){
        $sql = "select * from member where id = '$id'";
        
        $member_check = executeSingleResult($sql);
       
        if($member_check!=null){
         
            header('Location: index.php');
            die();
        }           
        $sql ='insert into member(id, pass, name, avatar, birth, email, phone, status )
        value("'.$id.'","'.$pass.'","'.$name.'","'.$avatar.'","'.$birth.'","'.$email.'","'.$phone.'","'.$status.'")';
    }else{
        $sql="update member set pass='$pass', name='$name',
        avatar='$avatar',birth='$birth',email='$email'
        ,phone='$phone',status='$status' where 
        id = '$id'";
    }
    execute($sql);
    header('Location: index.php');
    die();

}


$id=$pass=$name=$avatar=$birth=$email=$phone=$status=$action='';
if(isset($_GET['action'])){
$action=$_GET['action'];
}
if($action=='edit'){  
   
    if(isset($_GET['id'])){
        $id =$_GET['id'];       
         $sql = "select * from member where id = '$id'";
         $memberlist = executeSingleResult($sql);
         if($memberlist!=null){
            $pass=$memberlist['pass'];
            $name=$memberlist['name'];
            $avatar=$memberlist['avatar'];
            $birth=$memberlist['birth'];
            $email=$memberlist['email'];
            $phone=$memberlist['phone'];
            $status=$memberlist['status'];
           
         }
     }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Thêm/sửa món ăn</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
<body>
    <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="index.php">Quản lý Thành viên</a>
    </li>
    </ul>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Thêm/sửa Thành viên</h2>
			</div>
			<div class="panel-body">
                <form method="post" enctype="multipart/form-data">
                <?php
                 if($action=='add'){
                    echo'
                    <div class="form-group">
				        <label for="id">ID Thành viên:</label>
                        <input type="text" name="action" value="add" hidden="true">
                        <input required="true" type="text" class="form-control" id="id" name="id">
			        </div>';
                }else{
                    echo'
                    <div class="form-group">
				        <label for="id">ID Thành viên:</label> <span>'.$id.'</span>
                        <input type="text" name="action" value="edit" hidden="true">
                        <input type="text" name="id" value="'.$id.'" hidden="true">
			        </div>';
                }   
?>

                <div class="form-group">
				  <label for="pass">Mật khẩu:</label>
                <input required="true" type="text" class="form-control"
                   id="pass" name="pass" value="<?=$pass?>">
				</div>
                <div class="form-group">
				  <label for="name">Tên:</label>
                <input required="true" type="text" class="form-control"
                   id="name" name="name" value="<?=$name?>">
				</div>
                <div class="form-group">
				 <label for="image">Avatar:</label>
                <input required="true" type="file" accept=".png, .jpg, 
                .jpeg, .gif, .bmp, .tif, .jfif, .tiff|image/*"
                class="form-control" id="avatar" name="avatar" > 
				</div>  
                <div class="form-group">
				  <label for="birth">Ngày sinh:</label>
                <input required="true" type="date" class="form-control"
                   id="birth" name="birth" value="<?=$birth?>">
				</div>
                <div class="form-group">
				  <label for="email">Email:</label>
                <input required="true" type="mail" class="form-control"
                   id="email" name="email" value="<?=$email?>">
				</div>
                <div class="form-group">
				  <label for="phone">Số điện thoại:</label>
                <input required="true" type="number" class="form-control"
                   id="phone" name="phone" value="<?=$phone?>">
				</div>
                <div class="form-group">
				  <label for="status">Trạng thái:</label>
                <select class="form-control" name="status" id="status">
                <option value='1' >Không cấm</option>
                <option value='0' >Cấm</option>
                </select>
				</div>
				<button class="btn btn-success">Lưu</button>
                </form>
			</div>

			</div>
		</div>
	</div>
</body>
</html>

