<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>


        <br> <br>
        
        <?php
          if(isset( $_SESSION['add'] )) //checking whether the session is set or not
           {
             echo $_SESSION['add'];  //Displayong the session message if set
             unset($_SESSION[ 'add' ]); //Remove the session message
             }
        ?>

        <form action="" method="POST">
            
        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr> 

            <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" placeholder="Your Username">
                </td>
            </tr>

            <tr>
                <td>Password: </td>
                <td>
                    <input type="password" name="password" placeholder="Your password">
                </td>                
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">

                </td>
            </tr>
        </table>
        </form>
    </div>
</div>



<?php include('partials/footer.php'); ?>

<?php 
  //process the value form and save it in Database

  //check whether the submit button is clicked or not

  if(isset($_POST['submit']))
  {
    //Button clicked
    //echo "Button Clicked";

    //1.Get the Data from form 
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password Encrypyrd with MD5

    //2.sql Query to save data into database
    $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password' 
    
    ";

     //3.Executing Query and saving Data inti Database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4.check whether the (Query is executed) data is instered or not and display appropriate message
    if ($res==TRUE)
    {
       //Data Inserted
       //echo"Data Inserted";
       //create a variable to display message
       $_SESSION['add'] = "Admin  Added Successfully";
       //Redirect page to manage admin
       header("location:".SITEURL.'admin/manage-admin.php' );
    }
    else
     {
        //Failed to inserted data
        //echo"Fail to inserted Data";
        //create a variable to display message
       $_SESSION['add'] = "Failed to Add Admin";
       //Redirect page to manage admin
       header("location:".SITEURL.'admin/manage-admin.php' );

    }
    
  }
 

  ?>