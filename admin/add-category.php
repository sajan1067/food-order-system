<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add category</h1>
        <br><br>
        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br><br>
        <!-----Add category form starts--->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input  type="radio" name="featuerd" value="Yes"> Yes 
                        <input   type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input  type="radio" value="active" value="Yes"> Yes
                        <input  type="radio" value="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                    
                </tr>
            </table>
        </form>
         <!-----Add category form ends--->
<?php 
   //check wheather the submit button is clicked or not
   if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //1.GEt the value from category Form
        $title = $_POST['title'];
        //For radio input, we need to check wheather the button is selected or not
        if(isset($_POST['featured']))
        {
            //get the value from Form
            $featured = $_POST['featured'];
        }
        else
        {
            //set the default value
            $featured = "NO";
        }
        if(isset($_POST['active']))
        {
            $active = $_POST['active'];

        }
        else
        {
            $active = "No";
        }

        //check wheather the image is selected or not and set the value for image name accordingly
        //print_r($_FILES['image']);

        //die();//Break the code Here

        if(isset($_FILES['image']['name']))
        {
            

           
            //upload the image
            //to upload image we need image name source path and destination path
            $image_name = $_FILES['image']['name'];

            //Auto rename our images
            //Get the Extension of our image(jpg, png, gif, etc) e.g "special.food1.jpg"
            $ext = end(explode('.', $image_name));

            //Rename the image
            $image_name= "Food_Category_".rand(000, 999).'.'.$ext; //e.g < class="jpg">
            

            $source_path = $_FILES['image']['tmp_name'];

            $destination_path ="../images/category/".$image_name;
            //finally upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            //check wheather the is uploaded or no
            //if the image is not uploaded we will stop the process and redirected with error message
            if($upload==false)
            {
                //Set message
                $_SESSION['upload'] = "<div class='error'>Image could not be uploaded.</div>";
                //Redirect to add category page
                header('location:'.SITEURL.'admin/add-category.php');
                //stop the process
                die();
            }
            
        }
        
        else
        {
            //Donot  upload anything just take the old image name
            $image_name="";
        }
        //2.create sql query to insert category int0 database
        $sql = "INSERT INTO tbl_category SET
        title='$title',
        image_name='$image_name',
        featured='$featured',
        active='$active'
        
        ";
        //3.Executed the Query and save database
        $res = mysqli_query($conn, $sql);

        //4.check wheather the query  executed successfully or not
        if($res==true)
        {
            //query executed and category added
            $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //failed to add category
            $_SESSION['add'] = "<div class='error'>Failed to Add category.</div>";
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/add-category.php');
        }
    }
?>
    </div>
</div>

<?php include('partials/footer.php'); ?>