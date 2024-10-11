<?php
session_start();
if(!isset($_GET["pid"])){die("this poll does not exist");}

$pid=$_GET['pid'];
$tv=0;

?>





<?php

try{
    $t="";
    $vote=true;
    $sub=true;
    $a2=null;
    
    
    require("connection.php");
    $db->beginTransaction();
    require("headerLogin.php");


    $sql5="SELECT aid FROM votes WHERE qid=? AND id=? ";
    $stmt5=$db->prepare($sql5);
    $stmt5->execute(array($pid,$_SESSION['User']));
    if($stmt5->rowCount()>0){ 
        $a2=$stmt5->fetch(PDO::FETCH_ASSOC);
       
        $vote=false;}

        


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
    echo "<h1>".$row['question']."</h1><br>";
    if($t=="timer" && $vote==true){echo "<span style='color:blue'>This poll will end after this Date and Time :</span> ".$row['enddate']  ;}
    echo "<p>Make a choice:</p>";
    $sql2="SELECT * FROM answers WHERE qid=?";
    $stmt2=$db->prepare($sql2);
    $stmt2->execute(array($pid));
    $row2=$stmt2->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <form method="post" action="v.php">
        <input type='hidden' name='qid' value="<?php echo $pid ; ?> " >
        <input type='hidden' name='ed' value="<?php echo $row['enddate'] ; ?> " >
        <input type='hidden' name='t' value="<?php echo $row['type'] ; ?> " >
       
    
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
      
    <input type="submit" class="Abutton" id="s"  name="btn" value="Vote"  <?php if($vote==false){echo "disabled=none" ;} ?>
    > <span>   </span> 
    </form>
    <a href="R.php?qid=<?php echo $pid; ?>"><button class="Abutton" name="result">Result</button></a>
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

