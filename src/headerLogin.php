
<link rel="stylesheet" href="pstyle.css">


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

    textarea {
      width: 100%;
      height: 100px;
      padding: 5px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #3e8e41;
    }

    h2 {
      margin-bottom: 20px;
      font-style: Serif;
    }

    .error {
      color: red;
      margin-top: 5px;
    }


  </style>


<header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="logo.jpeg" alt="Logo"></a>
        <div class="headert">
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="createpoll.php">Create Poll</a>
        <a href="mypolls.php">My Polls</a>
        <a href="sessiondestroy.php">Logout</a>
        </div>
    </header>
    <hr>