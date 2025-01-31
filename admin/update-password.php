<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>change password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
        {
            $id= $_GET['id'];
        }
        
        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current password">
                </td>
            </tr>

            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm New Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="submit" name="submit" value="change password" class="btn-secondary">

                </td>
            </tr>

     </table>
        </form>
    </div>
</div>

<?php 
     //check whether the submit Button is clicked or not
     if (isset($_POST['submit']))
      {
       //echo "clicked";
       //1. get data from form
       $id= $_POST['id'];
       $current_password=md5($_POST['current_password']);
       $new_password = md5($_POST['new_password']);
       $confirm_password = md5($_POST['confirm_password']);

       //2. check  whether the user with current password and current id Exists or not
       $sql=  "SELECT * FROM tbl_admin WHERE id='$id' AND password= '$current_password'";
       //Execute the Query
       $res = mysqli_query($conn, $sql);

       if($res==true)
       {
        //checkwhether data is available or not
        $count=mysqli_num_rows($res);

        if( $count==1 )
        {
            //user Exixts and password can be changed
            //echo "User Found";
            //3. Check Whether new password and confirm password are same or not
             if ($new_password ===$confirm_password) 
             {
                //update password
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                 WHERE id='$id'
                  ";

                  //Executed the query
                  $res2 = mysqli_query($conn, $sql2);

                  //check wheather the query executed or not
                  if($res2== true)
                  {
                    //display message
                     //Redirect to manage Admin page with success message
                    $_SESSION['change-pwd'] = "<div class='success'>change password successfully.</div>";
                    //Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                  }
                  else{
                    //error message
                    //Redirect to manage Admin page with Error message
                    $_SESSION['change-pwd'] = "<div class='success'>Failed to change password.</div>";
                    //Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                  }
             }
             else{
                //Redirect to manage Admin page with Error message
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not match.</div>";
                //Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
             }
        }
        else
        {
            //user does not Exists set message and Redirect
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
            //Redirect the user
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
       }
       //3.check wheather the new password and confirms password match or not

       //4.chnage password if all above is true
      }
?>

<?php include('partials/footer.php'); ?>