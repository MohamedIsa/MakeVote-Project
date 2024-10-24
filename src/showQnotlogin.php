<?php

try{
    require('connection.php');
    $sql="SELECT * FROM questions ";
    $stmt=$db->prepare($sql);
    $stmt->execute();
    

        if($stmt->rowCount()<=0){

            echo "No Poll Are Available";
            $db=null;

        }else{

            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
          

            foreach($rows as $row=>$value){

                $sql2="SELECT name FROM users WHERE id=?";
                $stmt2=$db->prepare($sql2);
                $stmt2->execute(array($value['id']));
                $r=$stmt2->fetch(PDO::FETCH_ASSOC);


                ?>

                    


                    <div class="Cards">
                        <div class="QCard">
                            <img src="card.jpeg" alt="poll image">
                            <hr/>
                            <h5><?php echo $value['question']; ?></h5>
                            <hr>
                            <h6>This Poll made by  <?php echo " ".$r['name']; ?></h6>
                            <a class="cardB" href="pollNologin.php?pid=<?php echo $value['qid']; ?>">Enter</a>
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