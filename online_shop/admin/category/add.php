<?php
require_once('../../db/dbhelper.php');
require_once('../../funlib/funs.php');
$id=$name=$thumbnail=$action=$errol='';
if(!empty($_POST)){   
    if(isset($_POST['name'])){
        $name=$_POST['name'];
        $name =str_replace('"','\\"',$name);
    }
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }  
    if(isset($_POST['action'])){
        $action=$_POST['action'];
    }

    $thumbnail= moveFile('thumbnail','../../');

    if(!empty($name)){
        if($action =='add'){
            $sql = 'select * from category where id = '.$id;
            $category_check = executeSingleResult($sql);
            if($category_check!=null){
                header('Location: index.php');
                die();
            }           
            $sql ='insert into category(id, name, thumbnail)
        value("'.$id.'","'.$name.'","'.$thumbnail.'")';
        }else{
            $sql='update category set name="'.$name.'",
            thumbnail="'.$thumbnail.'" where 
            id = '.$id;
        }
        execute($sql);
        header('Location: index.php');
        die();
    }
}


$id=$name=$action='';
if(isset($_GET['action'])){
$action=$_GET['action'];
}

if($action=='edit'){   
    if(isset($_GET['id'])){
        $id =$_GET['id'];
         $sql = 'select * from category where id = '.$id;
         $category = executeSingleResult($sql);
         if($category!=null){
             $name=$category['name'];
             $thumbnail=$category['thumbnail'];
         }
     }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Thêm/sửa Danh mục</title>
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
        <a class="nav-link active" href="index.php">Quản lý Danh mục</a>
    </li>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Thêm/sửa Danh mục</h2>
			</div>
			<div class="panel-body">
                <form method="post" enctype="multipart/form-data">
                    
<?php
                 if($action=='add'){
                    echo'
                    <div class="form-group">
				        <label for="id">ID Danh mục:</label>
                        <input type="text" name="action" value="add" hidden="true">
                        <input required="true" type="text" class="form-control" id="id" name="id">
			        </div>';
                }else{
                    echo'
                    <div class="form-group">
				        <label for="id">ID Danh mục:</label> <span>'.$id.'</span>
                        <input type="text" name="action" value="edit" hidden="true">
                        <input type="text" name="id" value="'.$id.'" hidden="true">
			        </div>';
                }   
?>

                

                <div class="form-group">
				  <label for="name">Tên Danh mục:</label>
                <input required="true" type="text" class="form-control"
                   id="name" name="name" value="<?=$name?>">
				</div>



                <div class="form-group">
				 <label for="thumbnail">Hình ảnh:</label>
                <input required="true" type="file" accept=".png, .jpg, 
                .jpeg, .gif, .bmp, .tif, .jfif, .tiff|image/*"
                class="form-control" id="thumbnail" name="thumbnail"  > 
				</div>   
				<button class="btn btn-success">Lưu</button>
                </form>
			</div>

			</div>
		</div>
	</div>
</body>
</html>

