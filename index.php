<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php 
    if(isset($_SESSION['order']))
    {
      echo $_SESSION['order'];
      unset($_SESSION['order']);
    }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //create sql query to display categories
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 8";
                //execute the query
                $res = mysqli_query($conn, $sql);
                //count row to check wheather the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values like title, image from database table
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?> 
                          <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                           <div class="box-3 float-container">
                            <?php
                            //check wheather the image is available or not
                              if($image_name=="")
                              {
                                echo "<div class='error'>Image not available</div>";
                              }
                              else
                              {
                                ?>
                                  <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="veg-chowmin" class="img-responsive img-curve">

                                <?php
                              }
                            ?>
                            
                                 <h3 class="float-text text-white"><?php echo $title; ?></h3>
                             </div>
                            </a>
                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>category not added.</div>";
                }
             ?> 

            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            //Getting foods from Database that are active and featured
            //SQL QUERY
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 4";

            //Executed the query
            $res2 = mysqli_query($conn, $sql2);

            //count rows
            $count2 = mysqli_num_rows($res2);

            //check wheather food available or not
            if($count2>0)
            {
                while($row=mysqli_fetch_assoc($res2))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                      <div class="food-menu-box">
                      <div class="food-menu-img">
                        <?php
                           //check whether  image is available or not
                           if($image_name=="")
                           {
                            echo "<div class='error'>Image not available.</div>";
                           }
                           else
                           {
                             ?>
                                 <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                             <?php
                           }

                        ?>
                       
                      </div>

                      <div class="food-menu-desc">
                      <h4><?php echo $title; ?></h4>
                      <p class="food-price">Rs<?php echo $price; ?></p>
                      <p class="food-detail">
                        <?php echo $description; ?>
                       </p>
                      <br>

                      <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                      </div>
                      </div>

           


                    <?php
                } 
            }
            else
            {
                echo "<div class='error'>Food not available.</div>";
            }
            ?>
        <div class="clearfix"></div>

</div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


    <div style="display: flex; justify-content:center">
    <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31588.34227325167!2d83.44112232712637!3d27.658591633011863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3996853a51c26c61%3A0x8966c341d7c9f2a1!2sThe%20Green%20Leaf%20Restro!5e0!3m2!1sen!2snp!4v1715744587071!5m2!1sen!2snp" 
      width="800" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
    </div>
  <?php include('partials-front/footer.php'); ?>