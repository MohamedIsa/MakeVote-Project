<?php
session_start();

if(!isset($_SESSION['Active'])){die("You must login first");}
$pid=$_GET['pid'];
$tv=0;

try{

require("connection.php");
require("headerLogin.php");
$sql="SELECT * FROM questions WHERE qid=? AND id=?";
$stmt=$db->prepare($sql);
$stmt->execute(array($_GET['pid'],$_SESSION['User']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
date_default_timezone_set("Asia/Bahrain");
$cdate=date('Y-m-d H:i:s');
       
        
if($row['type']=="timer" && $cdate<$row['enddate']){
    echo "<h3 style='display:inline-block'>This poll will ended after this date and time:</h3><span style='color:blue'>".$row['enddate']."</span>";
}else if($row['type']=="normal"&&$row['status']=="live"){
    
    echo "<form method='post' action='endpoll.php'>
    <input type='hidden' name='qid' value='$row[qid]'>
    If you want to end the poll press this button:<input type='submit'class='Abutton' name='btn' value='End the poll'>
    
    
    </form>";
}else{
    echo "This poll is ended";
}
echo "<h1>".$row['question']."</h1>";

$sql2="SELECT * FROM answers WHERE qid=?";
$stmt2=$db->prepare($sql2);
$stmt2->execute(array($row['qid']));
$row2=$stmt2->fetchAll(PDO::FETCH_ASSOC);

foreach($row2 as $r){
    $tv+=$r['votenum'];
    echo $r['answer']."<br><br>";
}

?><a href="Rmy.php?qid=<?php echo $pid; ?>"><button class="Abutton" name="result">Result</button></a><?php
  echo "  ".$tv." Votes" ;

}catch(PDOException $e){
    die("Error :".$e);}



?>