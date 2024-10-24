<?php
session_start();

if(!isset($_SESSION['Active'])){die("You must login first");}
$pid=$_POST['qid'];
if(!isset($_POST['an'])){

    header("location:poll.php?pid=$pid");

}

$aid=$_POST['an'];
$ed=$_POST['ed'];
$t=$_POST['t'];
date_default_timezone_set("Asia/Bahrain");
$cdate=date('Y-m-d H:i:s');

if($t=="timer"&&$cdate>$row['enddate']){
$vote = false;
header("location:poll.php?pid=$pid");
}else{

try{
    require('connection.php');
        
    $db->beginTransaction();
            $sql3="UPDATE answers  SET votenum = votenum + 1 WHERE aid =?";
            $stmt3=$db->prepare($sql3);
            $stmt3->execute(array($aid));

            $sql4="INSERT INTO  votes (qid,aid,id) VALUES (?,?,?)";
            $stmt4=$db->prepare($sql4);
            $stmt4->execute(array($pid,$aid,$_SESSION['User']));
            header("location:poll.php?pid=$pid");
            $db->commit();
           
}catch(PDOException $e){
    
    $db->rollBack();
    die("Error :".$e);}

    $db=null;

}

?>