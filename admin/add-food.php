<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add food</h1>

        <br><br>

        <?php
         
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }  
        
        ?>
        <form action="" method="POST" enctype="multitype/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food" >
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" placeholder="Price of the food" >
                    </td>
                </tr><br>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                              //Create php code to display category from database
                              //1.create sql query to get all active category from database
                              $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                              //execute the query
                              $res =  mysqli_query($conn, $sql);
                              //count Rows to check wheather we have categories or not
                              $count = mysqli_num_rows($res);
                               if ($count>0)
                               {
                                  //we have category
                                  while($row=mysqli_fetch_assoc($res))
                                  {
                                    //get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>

                                      <option value="<?php echo $id; ?>"><?php echo $title; ?></option>


                                    <?php
                                  }
                               } 
                               else
                               {
                                  //we do not hace category
                                  ?>
                                    <option value="0">No category found</option>
                                  <?php

                               }



                              //display on Deepdown
                            ?>

                          
                        </select>  
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //Add the food in the database
               // echo "clicked";

               //1. get the data from Form
               $title = $_POST['title'];
               $description = $_POST['description'];
               $price = $_POST['price'];
               $category = $_POST['category'];
               if(isset($_POST['featured']))
               {
                $featured = $_POST['featured'];
               }
               else
               {
                $featured = "No"; //setting the default value
               }

               if(isset($_POST['active']))
               {
                $active = $_POST['active'];
               }
               else
               {
                $active = "No"; //setting default value
               }

               //2.Upload the images if selected
               //checked wheather the selected image or not and upload the image only if the image is selected
               if(isset($_FILES['image']['name'])) 
               {
                //get the details of the selected image
                $image_name = $_FILES['image']['name'];
                //check wheather the images is selected or not and upload image only if selected
                if($image_name!="")
                {
                    //image is selected
                    //a.Rename the image
                    //get the extension of selectd image (jpg, png, gif,etc)
                    $ext = end(explode(".", $image_name));

                    //create new name for image
                    $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                    //b.specify the directory to upload image
                    //Get the source path and destination path

                    //sourece path is the currebt location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination path for the images to be uploaded
                    $dst = "../images/food/".$image_name;

                    //finally upload food image
                    $upload = move_uploaded_file($src, $dst);
                    //check whether images uploaded or not
                    if($upload==false)
                    {
                        //failed to upload the image
                        //Redirect to add  page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //stop the process
                        die();
                    }
                }
               }
               else
               {
                 $image_name = ""; //setting default value as blank
               }

               //3.Insert into Database

               //create a sql query to save  data in database
               $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";

                //Executed the query
                $res2 = mysqli_query($conn, $sql2);
                //Check whether the query executed successfully or not
                //.Redirect with message to manage Food page
                if($res2 == true)
                {
                    //Query Executed Successfully
                    $_SESSION['add'] = "<div class='success'>Food added Successfully.</div>";
                    header('location:'.SITEURL. 'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to added food.</div>";
                    header('location:'.SITEURL. 'admin/manage-food.php');
                }
               

            }
         ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>