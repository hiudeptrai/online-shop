<?php
session_start();
require_once('../db/dbhelper.php');
require_once('../funlib/funs.php');
$action=$id=$num='';
if(isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch($action){
    case 'cart':
        addToCart();
        break;
    case 'deletecart':       
            unset($_SESSION['cart']);      
        break;
    case 'tym':
        addtym();
        break;
    case 'deleteitem':
        deleteitem();
        break;
    case 'getcount':
        getcount();
        break;
    case 'getsum':
        getsum();
        break;
    case 'gettotal':
        gettotal();
        break;
    case 'getlist':
        getlist();
        break;
    }

   

function addToCart(){

    if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
    if(isset($_POST['num'])) {
		$num = $_POST['num'];
	}


    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }
    
    $isFind = false;
    for($i=0;$i<count($_SESSION['cart']);$i++){
        if($_SESSION['cart'][$i]['id']==$id){
            $_SESSION['cart'][$i]['num']+=$num;
            if($_SESSION['cart'][$i]['num']<=0) {array_splice($_SESSION['cart'], $i, 1);}
            $isFind=true;
            break;
        }
    }

    if(!$isFind&&$num>0){
        $sql = 'select * from item where id = '.$id;
        $item=executeSingleResult($sql);
        $item['num'] = $num;
        $_SESSION['cart'][]=$item;
    }
    $output='';
    $sum_cost=0;
    $cart=[];
    if(!empty($_SESSION['cart'])){
      $cart=$_SESSION['cart'];
    }
    for($i=0;$i<count($cart);$i++){
      $gia=intval($cart[$i]['num'])*intval($cart[$i]['price']);
      $sum_cost=$sum_cost+$gia;
      $output.='
      <div class="row border-top ">
        <div class="row main align-items-center">
            <div class="col-2"><img class="img-fluid imgx" src="'.fixUrl($cart[$i]['image'],'../').'"></div>
            <div class="col">
            <div class="row text-muted"></div>
                <div class="row">'.$cart[$i]['name'].'</div>
            </div>
            <div class="col"> <button class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',-1)">-</button>
            <span   style="color: black;">'.$cart[$i]['num'].'</span>
            <button   class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',1)">+</button> </div>
            <div class="col">'.number_format($gia).' VNĐ<button class="close" onclick="deleteitem('.$cart[$i]['id'].')">&#10005;</button></div>
        </div>
    </div>
      ';
    }
    echo($output);
}

function addtym(){
    if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
    $sql = 'select tym from item where id = '.$id;
    $item=executeSingleResult($sql);
    $tym=$item['tym'];
    $tym++;
    $sql='update item set tym="'.$tym.'" where id = '.$id;  
    execute($sql);
    echo"$tym";
}

function deleteitem(){

    if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}

    if(isset($_SESSION['cart'])){
        for($i=0;$i<count($_SESSION['cart']);$i++){
            if($_SESSION['cart'][$i]['id']==$id){               
                array_splice($_SESSION['cart'], $i, 1);
                break;
            }
        }
    }
    $sum_cost=0;
    $output='';   
    $cart=[];
    if(!empty($_SESSION['cart'])){
      $cart=$_SESSION['cart'];
    }
    for($i=0;$i<count($cart);$i++){
      $gia=intval($cart[$i]['num'])*intval($cart[$i]['price']);
      $sum_cost=$sum_cost+$gia;
      $output.='
      <div class="row border-top ">
        <div class="row main align-items-center">
            <div class="col-2"><img class="img-fluid imgx" src="'.fixUrl($cart[$i]['image'],'../').'"></div>
            <div class="col">
            <div class="row text-muted"></div>
                <div class="row">'.$cart[$i]['name'].'</div>
            </div>
            <div class="col"> <button class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',-1)">-</button>
            <span   style="color: black;">'.$cart[$i]['num'].'</span>
            <button   class="btn btn-light" onclick="addCart('.$cart[$i]['id'].',1)">+</button> </div>
            <div class="col">'.number_format($gia).' VNĐ<button class="close" onclick="deleteitem('.$cart[$i]['id'].')">&#10005;</button></div>
        </div>
    </div>
      ';
    }
    echo($output);
}

function getlist(){
    $output='';   
    $cart=[];
    if(!empty($_SESSION['cart'])){
      $cart=$_SESSION['cart'];
    }
    for($i=0;$i<count($cart);$i++){
      $output.=''.$cart[$i]['name'].' : '.$cart[$i]['num'].' <br>';
    }
    echo($output);
}

function getsum(){
    $sum_cost=0;
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }
    for($i=0;$i<count($_SESSION['cart']);$i++){
        $gia=intval($_SESSION['cart'][$i]['num'])*intval($_SESSION['cart'][$i]['price']);
      $sum_cost=$sum_cost+$gia;}
    echo(number_format($sum_cost));
}

function getcount(){
    $count=0;
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }
    for($i=0;$i<count($_SESSION['cart']);$i++){
        $count+= $_SESSION['cart'][$i]['num'];}
    echo($count);
}

function gettotal(){
    $fee=0;
    if(isset($_POST['fee'])){
        $fee=$_POST['fee'];
    }
    $sum_cost=0;
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }
    for($i=0;$i<count($_SESSION['cart']);$i++){
        $gia=intval($_SESSION['cart'][$i]['num'])*intval($_SESSION['cart'][$i]['price']);
      $sum_cost=$sum_cost+$gia;}
    echo(number_format(($sum_cost==0)?0:($sum_cost+$fee)));
}