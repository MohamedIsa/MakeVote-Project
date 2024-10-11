<?php
 $state="";
try{

    require('connection.php');
    $eml=$_GET['email'];
    $sql="SELECT email FROM users WHERE email = :email";
    $stmt=$db->prepare($sql);
    $stmt->bindParam("email",$eml);
    $stmt->execute();
    
   
    if($stmt->rowCount() > 0){
        $state= "This email is not available";
    }


}catch(PDOException $e){
    die("Error: ".$e);
}

echo $state;


?>