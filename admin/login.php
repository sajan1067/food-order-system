  <?php include('../config/constants.php')   ?>
  
  <html>
    <head>
        <title>Login - Food order system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center"> Login</h1>
            <br><br>

            <?php 
               if(isset( $_SESSION['login']))
               {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
               }
               if(isset($_SESSION['no-login-message']))
               {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
               }
            ?>
            <br><br>
            <!---login form start here--->
            <form action="" method="post" class="text-center">
             username: <br>
             <input type="text" name="username" placeholder="Enter username"><br><br>
             password: <br>
             <input type="password" name="password" placeholder="Enter password"><br><br>

             <input type="submit" name="submit" value="Login" class="btn-primary">
             <br><br>
            </form>


            <!---login form end here--->

            <p class="text-center">Created By - Sajan G.c</p>
        </div>
    </body>
</html>
<?php 
      //check the submit button is clicked or not
      if(isset($_POST['submit']))
       {
          //process for login
          //1. Get the data from Logi n form
          $username= $_POST['username'];
          $password = md5($_POST['password']);//encrypt the password using MD5

          //2. SQL to check whether the user with username and password exists or not
          $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

          //3,executed the Query
          $res = mysqli_query($conn , $sql);

          //4.count rows to check the wheather  the user exist or not
          $count = mysqli_num_rows($res);

          if($count==1)
          {
            //user available and login success
            $_SESSION['login'] = "<div class='success'>Login successfull</div>";
            $_SESSION['user'] = $username;//to check wheather user is login or not and logout will unset it

            //Redirect to home page/Dashboard
            header('location:'.SITEURL.'admin/');

          }
          else
          {
            //user not available and login failed
            $_SESSION['login'] = "<div class='error text-center'>username or password did not match.</div>";
            //Redirect to home page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
          }


       }
?>