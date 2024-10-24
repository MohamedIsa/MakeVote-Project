<?php


try{
    require('connection.php');
    $sql="SELECT * FROM questions WHERE id = ?";
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_SESSION['User']));
    

        if($stmt->rowCount()<=0){

            echo "<h1>You have no polls</h4>";
            ?>
                <br><br><br><br><br><br><br><br><br><br><br>
            <?php
            $db=null;

        }else{

            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
          

            foreach($rows as $row=>$value){


                ?>

                    


                    <div class="Cards">
                        <div class="QCard">
                            <img src="card.jpeg" alt="poll image">
                            <hr/>
                            <h5><?php echo $value['question']; ?></h5>
                            <hr>
                            <a class="cardB" href="mypoll2.php?pid=<?php echo $value['qid']; ?>">Enter</a>
                        </div>
                    </div>

                

               <?php     

            }

            $db=null;


        }

        
        

    }catch(PDOException $e){
        die("Error :".$e);
    }
  
  ?>  