<?php
session_start();
$msg="";
$valid=true;
try{
    require("connection.php");
    
    if(isset($_POST['btn'])){

        $eml=$_POST['email'];
        $p=$_POST['password'];

        //check empty or not
        if (empty($p) || empty($eml) ) {
            $msg = "Please fill all the fields";
            $valid = false;
        }else{

            // Validate email
            if (!filter_var($eml, FILTER_VALIDATE_EMAIL)) {
                $msg = "Wrong Email or Password";
                $valid = false;
            }

             // Validate password
             if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $p)) {
                $msg = "Wrong Email or Password";
                $valid = false;
                }


                if ($valid==true) {

                        $sql="SELECT * FROM users WHERE email = ?";
                        $stmt=$db->prepare($sql);
                        $stmt->execute(array($eml));
                        $db=null;

                        if($stmt->rowCount()<=0){$msg="Wrong Email or Password";
                        }else{
                            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                            if(password_verify($p,$row['password'])){
                                $_SESSION['Active']=$row['name'];
                                $_SESSION['User']=$row['id'];
                                header("location:home.php");

                            }else{
                                ?>

                                  <script>

                                        alert('Wrong Email or Password');

                                  </script>  


                                <?php

                            }
                        }

                }





        }

    }




}catch(PDOException $e){
    die("Error :".$e);
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="pstyle.css">
</head>
<body>


<?php require("header.php"); ?>
    <hr>

    <main>
        <div class="logInBox">
            <?php echo "<p style='color:red; font: size 12px;'>".$msg."</p>"; ?>
            <h1>Login</h1>
            <form method="post">
                
                
            Email:<input type="email" class="tbox"  name="email" id="email" value="<?php if(isset($eml)) echo $eml;?>" placeholder="example@outlook.com"><br>

                
            Password:<input type="password" class="tbox"  name="password" id="password" value="<?php if(isset($p)) echo $p;?>" placeholder="Password">
                <input type="submit" class="Loginsb" name="btn" value="Login">
            </form>
        </div>
    </main>        

    <hr>
    <?php
    require("footer.php");
    ?>
</body>
</html>