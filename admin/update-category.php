<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
      <h1>Update Category</h1>

      <br><br>

      <?php 
           //check wheather the id set or not
           if(isset( $_GET['id']))
           {
            //Get the id and all other details
            //echo "getting the data";
            $id = $_GET['id'];
            //create sql query to get the category details from database using that id
            $sql = "SELECT * FROM tbl_category WHERE id='$id' ";
            //executed the query
            $res = mysqli_query($conn, $sql);
            //count the rows to check wheather the id is valid or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                //rediredt to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>category not found.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }

           }
           else
           {
            //redirect to menage category
            header('location:'.SITEURL.'admin/manage-category.php');
           }
      ?>

      <form action="" method="POSt" enctype="multipart/form-data">
      <table class="tbl_30">
        <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" value="<?php echo $title; ?>">
            </td>
        </tr>

        <tr>
            <td>Current Image: </td>
            <td>
               <?php 
                  if($current_image!= "")
                  {
                    //display the image
                    ?>
                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                    <?php
                  }
                  else
                  {
                     //display message
                     echo "<div class='error'>Image Not Added.</div>";

                  }
               ?>
            </td>
        </tr><br>

        <tr>
            <td>New Image: </td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>

        <tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured==""){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes 
                
                <input <?php if($featured==""){echo "checked";}  ?> type="radio" name="featured" value="No"> No
            </td>
        </tr>

        <tr>
            <td>Active: </td>
            <td>
                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
        </tr>

        <tr>
            <td>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
               <input type="submit" name="submit" value="update category" class="btn-secondary">
            </td>
        </tr>

      </table>
    </form>

    <?php
         
         if(isset($_POST['submit']))
         {
           // echo "clicked";
           //1.Get all the values from our form
           $id = $_POST['id'];
           $title = $_POST['title'];
           $current_image = $_POST['current_image'];
           $featured = $_POST['featured'];
           $active = $_POST['active'];

           //2.updating image if selected

           //3.update the database
           $sql2 = "UPDATE tbl_category SET
                title = '$title',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";
                //Ececuted the query
                $res2 = mysqli_query($conn, $sql2);

           //4.Redirect to message category with message
           //Check wheather executed or not
           if($res2==true)
           {
            //category update
            $_SESSION['update'] = "<div class='success'>Updated successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
           }
           else
           {
            //failed to update category
            $_SESSION['update'] = "<div class='error'>Failed to Updated. </div>";
            header('location:'.SITEURL.'admin/manage-category.php');

           }
            
           
         }

    ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>