<?php
require_once('../../db/dbhelper.php');

if(!empty($_POST)){
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        switch($action){
            case 'delete':
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $sql = 'delete from purchase where id = '.$id;
                    execute($sql);
                }
                break;
            case 'process':
                if(isset($_POST['id'])){                    
                    $id = $_POST['id'];
                    $status=0;
                    $sql = 'update purchase set status="'.$status.'" where id = '.$id;
                    execute($sql);
                }
                break;
        }   
    }
}