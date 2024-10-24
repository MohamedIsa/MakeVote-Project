<?php
session_start();

if(!isset($_SESSION['Active'])){
    echo "you must login first";
}else{?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Polls Page</title>
        <link rel="stylesheet" href="pstyle.css">
    </head>
    <body>

    <header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="logo.jpeg" alt="Logo"></a>
        <div class="headert">
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="createpoll.php">Create Poll</a>
        <a href="home.php">Home</a>
        <a href="sessiondestroy.php">Logout</a>
        </div>
    </header><hr>

    <?php
    
    try{

        require("connection.php");

        
        require("showMYQ.php");

        
        require("footer.php");

    }catch(PDOException $e){
        die("Error :".$e);
    }    
    
    
    ?>
        
    </body>
    </html>


   <?php
}
   ?>


