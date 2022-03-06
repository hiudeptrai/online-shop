<?php
require_once('../../db/dbhelper.php');
require_once('../../funlib/funs.php');
$id=$name=$image=$descript=$content=$price=$category_id='';
if(!empty($_POST)){   
    if(isset($_POST['name'])){
        $name=$_POST['name'];
        $name =str_replace('"','\\"',$name);
    }
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }
    $image= moveFile('image','../../');

    if(isset($_POST['descript'])){
        $descript=$_POST['descript'];
        $descript =str_replace('"','\\"',$descript);
    }
    if(isset($_POST['content'])){
        $content=$_POST['content'];
        $content =str_replace('"','\\"',$content);
    }
    if(isset($_POST['price'])){
         $price=$_POST['price'];
        $price =str_replace('"','\\"',$price);

    }
    if(isset($_POST['category_id'])){
        $category_id=$_POST['category_id'];
       $category_id =str_replace('"','\\"',$category_id);

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
        $sql = 'select * from item where id = '.$id;
        $item_check = executeSingleResult($sql);
        if($item_check!=null){
         
            header('Location: index.php');
            die();
        }           
        $sql ='insert into item(id, name, price, image, description, content, category_id)
        value("'.$id.'","'.$name.'","'.$price.'","'.$image.'","'.$descript.'","'.$content.'","'.$category_id.'")';
    }else{
        $sql='update item set name="'.$name.'", price="'.$price.'",
        image="'.$image.'",description="'.$descript.'",content="'.$content.'",category_id="'.$category_id.'" where 
        id = '.$id;
    }
    execute($sql);
    header('Location: index.php');
    die();

}



$id=$name=$price=$image=$descript=$content=$category_id=$action='';
if(isset($_GET['action'])){
$action=$_GET['action'];
}
if($action=='edit'){   
    if(isset($_GET['id'])){
        $id =$_GET['id'];
        
         $sql = 'select * from item where id = '.$id;
         $itemlist = executeSingleResult($sql);
         if($itemlist!=null){
            $name=$itemlist['name'];
            $price=$itemlist['price'];
            $image=$itemlist['image'];
            $content=$itemlist['content'];
            $category_id=$itemlist['category_id'];
            $descript=$itemlist['description'];
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
        <a class="nav-link active" href="index.php">Quản lý Sản phẩm</a>
    </li>
    </ul>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Thêm/sửa Sản phẩm</h2>
			</div>
			<div class="panel-body">
                <form method="post" enctype="multipart/form-data">
                <?php
                 if($action=='add'){
                    echo'
                    <div class="form-group">
				        <label for="id">ID Sản phẩm:</label>
                        <input type="text" name="action" value="add" hidden="true">
                        <input required="true" type="text" class="form-control" id="id" name="id">
			        </div>';
                }else{
                    echo'
                    <div class="form-group">
				        <label for="id">ID Sản phẩm:</label> <span>'.$id.'</span>
                        <input type="text" name="action" value="edit" hidden="true">
                        <input type="text" name="id" value="'.$id.'" hidden="true">
			        </div>';
                }   
?>
                <div class="form-group">
				  <label for="name">Tên sản phẩm:</label>
                <input required="true" type="text" class="form-control"
                   id="name" name="name" value="<?=$name?>">
				</div>
                <div class="form-group">
				  <label for="category_id">Danh mục:</label>
                <select class="form-control" name="category_id" id="category_id">
                <option >-- Lựa chọn danh mục --</option>
<?php
$sql = 'select * from category';
$categoryList = executeResult($sql);

foreach($categoryList as $item){
    if($item['id']==$category_id){
        echo'<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
    }else{
        echo'<option value="'.$item['id'].'">'.$item['name'].'</option>';
    }
}
?>
                </select>
				</div>
                <div class="form-group">
				  <label for="price">Giá bán:</label>
                <input required="true" type="number" class="form-control"
                   id="price" name="price" value="<?=$price?>">
				</div>
                <div class="form-group">
				 <label for="image">Hình ảnh:</label>
                <input required="true" type="file" accept=".png, .jpg, 
                .jpeg, .gif, .bmp, .tif, .jfif, .tiff|image/*"
                class="form-control" id="image" name="image" > 
                   <img src="<?=fixUrl($image,'../../')?>" alt="Ảnh minh họa" 
                   style="max-width:200px; margin-top:5px" id="img_thumbnail">
				</div>  
                <div class="form-group">
				  <label for="descript">Mô tả ngắn:</label>
                <textarea class="form-control" name="descript" id="descript" 
                rows="2" ><?=$descript?></textarea>
				</div> 
                <div class="form-group">
				  <label for="content">Nội dung:</label>
                <textarea class="form-control" name="content" id="content" 
                rows="5" ><?=$content?></textarea>
				</div>
				<button class="btn btn-success">Lưu</button>
                </form>
			</div>

			</div>
		</div>
	</div>
    <script type="text/javascript">

        $(function(){
            $('#content').summernote({
            height: 350,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            }
            });
        })
        $(function(){
            $('#descript').summernote({
            height: 150,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            }
            });
        })
    </script>
</body>
</html>

