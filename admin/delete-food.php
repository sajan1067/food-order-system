<?php
        include('../config/constants.php');
        if(isset($_GET['id']) AND isset($_GET['image_name']))
        {
            //echo "process to delete";
            //1.Get ID and image name
            $id = $_GET['id'];
            $image_name= $_GET['image_name']; 

            //2.remove the image if available
             if($image_name != "")
             {
                $path = "../images/food/".$image_name;
                $remove = unlink($path);
                if($remove==false)
                {
                    $_SESSION['upload'] = "<div class= 'error'>Failed to remove images files.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }
             }

            //3.Redirect to manage food with session message
            $sql = "DELETE FROM tbl_food WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            if($res==true) 
            {
               $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
               header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['delete'] = "<div class='error'>Failed to Deleted Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        }
        else
        {
           $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
           header('location:'.SITEURL.'admin/manage-food.php');
        }

?>