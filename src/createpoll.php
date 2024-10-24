<?php
session_start();

if(!isset($_SESSION['Active'])){die("You have to login first");}

$msg="";
$valid=true;

if(isset($_POST['btn'])){

    $q = $_POST['q'];
    $t = $_POST['form-type'];
    $a = $_POST['answer'];
    $d = $_POST['date'];

    

    foreach($a as $ans){
        if(empty($ans)){
            $msg = "Please fill all the fields";
            $valid = false;
        }
    }


    if (empty($q) || empty($t)) {
        $msg = "Please fill all the fields";
        $valid = false;
        
    
    } 
    
    // Validate type
    if (!preg_match("/^normal$|^timer$/", $t)) {
        $msg = "type not valid";
        $valid = false;
    }else if($t==="timer"){

        $dateRegex = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/';
        if(!preg_match($dateRegex,$d)){
            $msg = "Date not valid";
            $valid = false;
        }
    
    }else if($t=="normal"){

        if(!empty($d)){
            $msg = "Date not valid";
            $valid = false;
        }

    }else{
        

            //Validate question
            if (!preg_match("/^[a-zA-Z0-9\s\?]+$/", $q)) {
                $msg = "Question not valid";
                $valid = false;
            }
            

           

            foreach($a as $ans){
                        // Validate answer
                        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $ans)) {
                        $msg = "Invalid Answer";
                        $valid = false;
                        }
                }


    }
    
    if ($valid==true) {
        
        try{
            require("connection.php");
            $db->beginTransaction();
            
           
            $sql="INSERT INTO questions (id,question,type,enddate,status) VALUES(?,?,?,?,?)";
            $stmt=$db->prepare($sql);
            $stmt->execute(array($_SESSION['User'],$q,$t,$d,"live"));

            $insertId = $db->lastInsertId();
           
            foreach($a as $ans){
            $sql2="INSERT INTO answers (qid,answer,votenum) VALUES(?,?,?)";
            $stmt2=$db->prepare($sql2);
            $stmt2->execute(array($insertId,$ans,0));
            }

            $db->commit();
            
        }catch(PDOException $e){
            $db->rollBack();
            die("Error :".$e);
        }

        $db=null;
        header("Location: home.php?alert=success");
            

    }
}








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create poll page</title>

    <style>
    .main {
      margin: 20px 20px 20px 5px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="number"] {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    select {
      width: 100%;
      padding: 5px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    
    button {
      background-color: #0077B6;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #03045E;
    }
    h2 {
      margin-bottom: 20px;
    }
    .error {
      color: red;
      margin-top: 5px;
    }
  </style>

</head>
<body>


<header>
    <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="logo.jpeg" alt="Logo"></a>
    <div class="headert">
    </div>
  </header>

  <?php echo $msg; ?>

  <main>
    <form class="main"  method="post" onsubmit="return validateForm();">
      <h2>Poll Form</h2>
      <label for="Question">Question:</label>
      <input type="text" id="q" name="q" placeholder="Question"><br>
      <span class="error" id="question-error"></span><br>

      <label for="Form-type">Form type:</label>
      <select id="form-type" name="form-type" onchange="showDateField()">
        <option value="">Select a type</option>
        <option value="normal">Manual</option>
        <option value="timer">Timer</option>
      </select><br>
      <span class="error" id="form-type-error"></span><br>

      <div id="date-field" style="display: none;">
      <label for="date-input">Choose Date and Time to end the poll after it:</label>
      <input type="datetime-local" id="date-input" name="date">
    </div><br>
      

      <div id="formContainer">
      <label for="Answers">Answers:</label>
            <input type="text" name="answer[]" required><br>
            <input type="text" name="answer[]" required><br>
         
        </div>
        <span class="error" id="question-error"></span><br><br>

        <button type="button" id="addButton">Add Answer</button>
        <button type="button" id="removeButton">Remove Answer</button><br><br><br>

      <button type="submit" name="btn" >Create</button>
    </form>
  </main>

  <?php require("footer.php"); ?>
    <script>
         let answerCount = 1; // Initial number of answer fields
        function validateForm() {
            // Retrieve the form inputs
            let q = document.getElementById('q').value;
            let ft = document.getElementById('form-type').value;
            let displayAnswers = document.getElementById("poll-display-answers").value;

            // Regular expressions for validation
            let qReg = /^[a-zA-Z0-9\s\?]+$/;
            let ftReg=/^normal$|^timer$/;
            let daReg = /^[2-9]$|^[0-9][0-9]{2,}]$/;

            // Flag to track validation status
            let isValid = true;

            // Validate Question
            if (!qReg.test(q)) {
                document.getElementById("question-error").innerHTML = 'Please enter a valid Question.';
                isValid = false;
            } else {
                document.getElementById("question-error").innerHTML = '';
            }

            // Validate Form type
            if (!ftReg.test(ft)) {
                document.getElementById('form-type-error').innerHTML = 'Please select a type.';
                isValid = false;
            } else {
                document.getElementById('form-type-error').innerHTML = '';
            }

            // Validate display answers
            if (!daReg.test(displayAnswers)) {
                document.getElementById('display-answers-error').innerHTML = 'Please enter a number grater than 1';
                isValid = false;
            } else {
                document.getElementById('display-answers-error').innerHTML = '';
            }


            // Return the validation status
            return isValid;
            }


           
    
  </script>

<script>
        window.addEventListener('DOMContentLoaded', function() {
            let addButton = document.getElementById('addButton');
            let removeButton = document.getElementById('removeButton');
            var counter = 1;
            let formContainer = document.getElementById('formContainer');
           

            addButton.addEventListener('click', function() {
                let newField = document.createElement('input');
                newField.type = 'text';
                newField.name = 'answer[]';
                newField.setAttribute('required', 'required');
                formContainer.appendChild(newField);
                formContainer.appendChild(document.createElement('br'));
                counter++;
               
            });

            removeButton.addEventListener('click', function() {
                if (counter > 1) {
                    counter--;
                    let lastField = formContainer.lastElementChild;
                    formContainer.removeChild(lastField);
                    formContainer.removeChild(formContainer.lastElementChild); // Remove the line break
                }
            });

        });
    </script>

<script>
    function showDateField() {
      let selectedOption = document.getElementById("form-type").value;
      let dateField = document.getElementById("date-field");

      if (selectedOption === "timer") {
        dateField.style.display = "block";
      } else {
        dateField.style.display = "none";
      }
    }
  </script>


    
    
  
</body>
</html>