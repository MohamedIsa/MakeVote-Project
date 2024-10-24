<?php
try{
    require('connection.php');
   
    $msg = "";
    $valid = true;

    if(isset($_POST['btn'])){
        //get the values
        $un= $_POST['name'];
        $eml= $_POST['email'];
        $ps= $_POST['password'];
        $cps= $_POST['cpassword'];

        //check empty or not
        if (empty($un) || empty($eml) || empty($ps) || empty($cps)) {
            $msg = "Please fill all the fields";
            $valid = false;
        }else{
            

                //Validate name
                if (!preg_match("/^[a-zA-Z0-9]{3,15}$/", $un)) {
                    $msg = "name not valid ";
                    $valid = false;
                }
                

                // Validate email
                if (!filter_var($eml, FILTER_VALIDATE_EMAIL)) {
                    $msg = "Email not valid";
                    $valid = false;
                }

                // Validate password
                if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $ps)) {
                $msg = "Password not valid your password must have a one capital letter and one small letter and one special character and one number";
                $valid = false;
                }


                // Confirm password
                if ($ps !== $cps) {
                $msg = "Passwords do not match";
                $valid = false;
                }

        }
        
        if ($valid==true) {

            $sql1="SELECT email FROM users WHERE email LIKE ? ";
            
            $stmt=$db->prepare($sql1);
            $stmt->execute(array($eml));
            $rows=$stmt->rowCount();
            if($rows > 0){
                $msg='This email is already taken please try another email';               
            }else{
            

                $hPassword = password_hash($ps, PASSWORD_DEFAULT);
                
                $sql2 = "INSERT INTO users VALUES (null, ?, ?, ?)";
                $stmt2=$db->prepare($sql2);
                $stmt2->execute(array($un,$eml,$hPassword));

                if ($stmt2 == true) {
                    ?>

                    <script>
                       alert('you have registered successfully');
                       location.href = 'login.php';
                    </script>
                    
                <?php
                //header("location:login.php");
                } else {
                    $msg = "There was an error while registering";
                }

                $db = null;

        }


        }



    }



}catch(PDOException $e){

    die("Error: ".$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    
    
</head>
<body>

    <?php require("header.php"); ?>
    <hr>
    
    <div class="rbox">
        <h1>Register</h1><br>
         <?php echo $msg." <br>"; ?>
            <form method="post" onsubmit="return validateForm();">
                
                Name:<br>
                <input type="text" class="rinput" placeholder="name" name="name" id="name" value="<?php if(isset($un)) echo $un;?>"><br>
                <br>

                Email:<br>
                <input type="email" class="rinput" placeholder="example@outlook.com" name="email" id="email" onkeyup="checkEmail(this.value)" value="<?php if(isset($eml)) echo $eml;?>"><br>
                <p id="e2" style="color:red; font-size:12px; "></p><br>
                Password:<br>
                <input type="password" class="rinput" placeholder="Enter a password" name="password" id="password" value="<?php if(isset($ps))echo $ps;?>"><br>
                <br>
                Confirm Password:<br>
                <input type="password" class="rinput" placeholder="Confirm your password" name="cpassword" id="cpassword" value="<?php if(isset($cps))echo $cps;?>"><br>
                <br>
                <input type="submit" class="rbutton" name="btn" value="register" >
                <a href="home.php"><input class="rbutton" type="button" value="Cancel"></a>
            </form>
    </div>

    <hr>
    <?php
    require("footer.php");
    ?>
    





    <script>

       function validateForm(){

            let n=document.getElementById("name").value;
            let eml=document.getElementById("email").value;
            let ps=document.getElementById("password").value;
            let cps=document.getElementById("cpassword").value;

            let errorMsg = "please check the requirements \n";
            let valid = true;

            if (n.trim() === "") {
                errorMsg += "- Please enter a name\n";
                document.getElementById("name").style.border="1px solid red";
                 valid = false;
            }else {
                document.getElementById("name").style.border="1px solid lightgreen"; 
            }

            let nameRX = /^[a-zA-Z0-9]{3,15}$/;
            if (!nameRX.test(n)) {
                errorMsg += "- name not valid\n";
                document.getElementById("name").style.border="1px solid red";
                valid = false;
            }

            if (eml.trim() === "") {
                errorMsg += "- Please enter your email\n";
                document.getElementById("email").style.border="1px solid red";
                valid = false;
            }

            // Email format validation using regular expression
            let emailRX = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailRX.test(eml)) {
                errorMsg += "- Email not valid\n";
                document.getElementById("email").style.border="1px solid red";
                valid = false;
            }else{
                
                document.getElementById("email").style.border="1px solid lightgreen";
                
            }

            if (ps.trim() === "") {
                errorMsg += "- Please enter a password\n";
                document.getElementById("password").style.border="1px solid red";
                valid = false;
            }

            let passRX =/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
            if (!passRX.test(ps)) {
                errorMsg += "- password not valid you must have at least one capital letter and one small letter and one special character and one number\n";
                document.getElementById("password").style.border="1px solid red";
                valid = false;
            }else{
                document.getElementById("password").style.border="1px solid lightgreen"; 
            }

            if (cps.trim() === "") {
                errorMsg += "- Please confirm your password\n";
                document.getElementById("cpassword").style.border="1px solid red";
                valid = false;
            }else{
                document.getElementById("cpassword").style.border="1px solid lightgreen"; 
            }

            if (ps !== cps) {
                errorMsg += "- Passwords do not match\n";
                document.getElementById("password").style.border="1px solid red";
                document.getElementById("cpassword").style.border="1px solid red";
                valid = false;
            }

            if (!valid) {
                alert(errorMsg);
                return false;
            }else{
                return true;
            }

       }


       function checkEmail(email){
            if(email.length == 0){
                document.getElementById("e2").innerHTML="";
                return;
            }else{
                const xhttp = new XMLHttpRequest();
                xhttp.onload = emailFunction;
                xhttp.open("GET","verifyEmail.php?email="+email);
                xhttp.send();
            }

            
       }

       function emailFunction(){
        document.getElementById("e2").innerHTML=this.responseText;

       }
        
    </script>    
</body>
</html>