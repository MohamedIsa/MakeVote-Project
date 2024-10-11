<?php
session_start();
$qid=$_POST['qid'];
$id=$_SESSION['User'];



try{
require("connection.php");
$sql="UPDATE questions SET status = 'ended' WHERE qid=? AND id=?";
$stmt=$db->prepare($sql);
$stmt->execute(array($qid,$id));
header("location:mypoll2.php?pid=$qid");


}catch(PDOException $e){
    die("Error :".$e);
}



?>