<?php 
     
     //include constant.php file here
     include('../config/constants.php');

     //1.get thethe ID of Admin to be DELETED
     $id = $_GET['id'];

     //2.Create sql query to delete admin
     $sql = "DELETE FROM tbl_admin WHERE id='$id'";

     //executed the query
     $res = mysqli_query($conn, $sql);

     //check whether the query  is executed successfully or not
     if($res==true)
     {
        //query executed successuly and admin Deleted
       // echo "Admin Deleted";
       //create session variable to display message
       $_SESSION['delete'] = "<Admin class='success'>Admin Deleted Successfully.</div>";
       //Redirect to manage admin page
       header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else
     {
        //failed to Delete Admin
       //echo "Failed To Delete Admin";
       $_SESSION['delete'] = "<div class='error'>Failed To Delete Admin. Try Again Later.</div>";
       header('location:'.SITEURL.'admin/manage-admin.php');
     }

     //3.Redirect user back to admin page with message (sucess/error)


?>