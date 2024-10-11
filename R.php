<?php

session_start();




$qid = isset($_GET['qid']) ? $_GET['qid'] : null;
$tv=0;




if (empty($qid)) {
    echo "No poll ID specified.";
    
}

try{
    require("connection.php");
    if(isset($_SESSION['Active'])){require("headerLogin.php");}else{require("header.php");}
    $sql="SELECT * FROM answers WHERE qid=?";
    $stmt=$db->prepare($sql);
    $stmt->execute(array($qid));
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    

    foreach($rows as $row){
        $tv+=$row['votenum'];
    }

    if($tv==0){
        foreach($rows as $r){
            echo "<p>". $r['answer']      .":         0%(0 votes) </p>" ;
            echo "
            <div  style='width: 500px; height: 10px; border: 2px solid black; border-radius:25px 25px 25px 25px;'>
            <div  style=' width:0% ;  height: 10px;   background-color: blue;  border-radius: 40px 40px 40px 40px;'>
            </div>
            </div>
            ";
        }
        echo"number of Total votes : 0";
    }else{

        foreach($rows as $r){

            $x=($r['votenum']/$tv)*100;

            echo "<p>". $r['answer'].":".$x."%(".$r['votenum']." votes) </p>" ;
            echo "
            <div  style='width: 500px; height: 10px; border: 2px solid black; border-radius:25px 25px 25px 25px;'>
            <div  style=' width:$x% ;  height: 10px;   background-color: blue;  border-radius: 40px 40px 40px 40px;'>
            </div>
            </div>
            ";
        }
        echo"<br>number of Total votes : $tv  <br>";

        ?>
        
        <?php
        


    }
    

    $db=null;

    

}catch(PDOException $e){
    die("Error :".$e);
}


if(isset($_SESSION['Active'])){
    echo "<br><a  href='poll.php?pid=$qid;'><button class='Abutton'>Back</button></a>";
}else{
    echo "<br><a  href='pollNologin.php?pid=$qid;'><button class='Abutton'>Back</button></a>";
}

?>


<?php

try{
    require("footer.php");
}catch(PDOException $e){
    die("Error :".$e);
}

?>
        



