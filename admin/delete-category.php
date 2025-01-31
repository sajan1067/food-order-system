<?php
     //include constant file
     include('../config/constants.php');
    //echo "Delete page";
    //check wheather the id and image_name is set or not
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //get the value and delete
        // echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        //Remove the physical image file is available
        if($image_name !="")
        {
            //image is Available.So remive it
            $path = "../images/category/".$image_name;
            //Remove the image
            $remove = unlink($path);
            //if failed to remove then add an error message and stop yhe process
            if($remove==false)
            {
                //set to session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove the image.Please try again.</div>";
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }
        //Delete data frim Database
        //sql query to delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Executed the Query
        $res = mysqli_query($conn, $sql);

        //check wheather the data is delete from database or not
        if($res==true)
        {
            //set success message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //set fail message and Redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Deleted category. </div>";
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        


    }
    else
    {
        //Redirect to manage category page
        header("location:".SITEURL."admin/manage-category.php");
    }
 ?>