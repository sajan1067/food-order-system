<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>update Admin</h1>
        <br><br>

        <?php  
             //1.Get the ID of selected Admin
             $id=$_GET['id'];

             //2.Create a sql query to get the Details
            $sql= "SELECT * FROM tbl_admin WHERE id=$id";

            //3.Executed the Query
            $res=mysqli_query($conn, $sql);

            //check whether the query is executed or not
            if($res==true)
            {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                //check whether we have admin data or not
                if($count==1)
                {
                    //Get the details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else{
                    //Rediredt to manage  admin page with error message
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
          ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden"  name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="update Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
            


        </form>
    </div>
</div>

<?php 
   //check whether the submit button is clicked or not
   if(isset($_POST["submit"]))
   {
    //echo "Button Clicked";
    //Get all the values from form to update 
     $id = $_POST['id'];
     $full_name=$_POST['full_name'];
     $userName=$_POST['username'];
     //create a sql query to update Admin
     $sql = "UPDATE tbl_admin SET
     full_name = '$full_name',
     username = '$username' 
     WHERE id='$id' 
     ";

     //Executed a query
     $res = mysqli_query($conn, $sql);
     
     //Check whether the data is updated in database or not
     if ($res==true)
     {
        //Query Executed and Admin updated
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div> ";
        //Redirect to manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else 
     {
        //Failed to update Admin
        $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div> ";
        //Redirect to manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }
   }

?>




<?php include('partials/footer.php');  ?>