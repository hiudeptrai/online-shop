<?php
require_once('../../db/dbhelper.php');
echo'a';
if(!empty($_POST)){
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        switch($action){
            case 'delete':
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $sql = "delete from member where id = '$id'";
                    echo ($sql);
                    execute($sql);
                }
                break;
            case 'ban':
                if(isset($_POST['id'])){                    
                    $id = $_POST['id'];
                    $status=0;
                    $sql = "update member set status='.$status.' where id = '$id'";
                    echo ($sql);
                    execute($sql);
                }
                break;
            case 'unban':
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $status=1;
                    $sql = "update member set status='.$status.' where id = '$id'";
                    execute($sql);
                }
                break;
        }   
    }
}