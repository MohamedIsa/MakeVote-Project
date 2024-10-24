<?php
session_start();

if(isset($_SESSION['Active'])){

  if (isset($_GET['alert'])) {
    $alert = $_GET['alert'];
    if ($alert === "success") {
        echo"<script>";
        echo "alert('you created poll succesfully');";
        echo "</script>";
    }
}
      
    ?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <link rel="stylesheet" href="pstyle.css">
        
        

       

    </head>
    <body>


    

        
      <?php
      
        try{
                require("headerLogin.php");
                require("showQ.php");
                require("footer.php");


        }catch(PDOException $e){
            die("Error :".$e);
        }



        ?>




        
    </body>
    </html>







<?php    
}else{

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
    </head>
    <body>

    <?php require("header.php");?><hr><?php
    
          require("showQnotlogin.php");
          require("footer.php");  
    
    ?>




        
    </body>
    </html>


<?php
}




?>