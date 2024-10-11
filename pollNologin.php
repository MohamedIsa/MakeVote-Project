<?php
session_start();
if(!isset($_GET["pid"])){die("this poll does not exist");}

$pid=$_GET['pid'];
$tv=0;

?>





<?php

try{
    $t="";
    $vote=false;
    $sub=true;
    $a2=null;
    
    
    require("connection.php");
    require("header.php");?><hr><?php
    $db->beginTransaction();

    $sql="SELECT * FROM questions WHERE qid=?";
    $stmt=$db->prepare($sql);
    $stmt->execute(array($pid));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $t=$row['type'];
     if($row['type']=="normal" && $row['status']=="ended"){
        $vote=false;
        echo "<p style='color:blue'>This Poll is ended </p>" ;
    }else if($row['type']=="timer"){
        date_default_timezone_set("Asia/Bahrain");
        $cdate=date('Y-m-d H:i:s');
       
        if($cdate>$row['enddate']){
        $vote = false;
        echo "<p style='color:blue'>This Poll has ended.</p>";
        }
     } 
     echo "<p style='color:orange'>Please if you want to be able to vote you must login first</p>";
    echo "<h1>".$row['question']."</h1><br>";
    if($t=="timer" && $vote==true){echo "<span style='color:blue'>This poll will end after this Date and Time :</span> ".$row['enddate']  ;}
    echo "<p>Make a choice:</p>";
    $sql2="SELECT * FROM answers WHERE qid=?";
    $stmt2=$db->prepare($sql2);
    $stmt2->execute(array($pid));
    $row2=$stmt2->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <form method="post">

       
    
    <?php
    foreach($row2 as $ans){
        $tv+=$ans['votenum'];
        echo "<input type='radio' name='an' value='$ans[aid]'";


        if(isset($a2)){
            if ($ans['aid'] == $a2['aid']) {
                echo " checked";
            }
        }   

    echo ">".$ans['answer']."<br>";
        
       
    }
    ?> 
    <br>
      
    <input type="submit" name="btn" class="Abutton"  value="Vote"  <?php if($vote==false){echo "disabled=none" ;} ?>
    > 

   
   
    </form>
    <a href="R.php?qid=<?php echo $pid; ?>"><input type="button" class="Abutton"  name="result" value="Result" <?php if (($row['type'] == "normal" && $row['status'] == "live") || ($row['type'] == "timer" && $cdate < $row['enddate'])) {echo "disabled";} ?>  ></a>
    <?php  echo $tv." Votes" ?>
    <?php
    require("footer.php");

   
        $db->commit();

}catch(PDOException $e){
    $db->rollBack();
    die("Error :".$e);
}
$db=null;

if(isset($_SESSION['Active'])){

}else{

}

?>