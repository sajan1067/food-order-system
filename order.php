<?php include('partials-front/menu.php'); ?>

    <?php 
        if(isset($_GET['food_id']))
        {
           $food_id = $_GET['food_id'];

           $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

           $res = mysqli_query($conn, $sql);

           $count = mysqli_num_rows($res);

           if($count==1)
           {
             $row = mysqli_fetch_assoc($res);
             $title = $row['title'];
             $price = $row['price'];
             $image_name = $row['image_name'];
           }
           else
           {
            header('location:'.SITEURL);
           }
        } 

        else
        {
            header('location:'.SITEURL);
        }
        

    
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">Rs<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <!-- <input type="number" name="qty" class="input-responsive" value="1" required> -->
                        <input type="text" name="qty" class="input-responsive" pattern="\d{-1}" title="Shouldnot be negative" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <!-- <input type="number" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required> -->
                    <input type="text" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" pattern="\d{10}" title="Please enter a 10-digit phone number" required>
        <br>
                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. sajan@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php 
            date_default_timezone_set("Asia/Kathmandu");

               if(isset($_POST['submit']))
               {
                 $food = $_POST['food'];
                 $price = $_POST['price'];
                 $qty = $_POST['qty'];

                 $total = $price * $qty;

                 $order_date = date("y-m-d h:i:sa");

                 $status = "ordered"; //ordered, on delievery, cancelled

                 $customer_name = $_POST['full-name'];
                 $customer_contact = $_POST['contact'];
                 $customer_email = $_POST['email'];
                 $customer_address = $_POST['address'];

                 //additional validation for phone number
                 $customer_contact = preg_replace('/\D/', '', $customer_contact);



                 //save the order in database
                 //create sql to save the data
                 $sql2 = "INSERT INTO tbl_order SET
                   food = '$food',
                   price = $price,
                   qty = $qty,
                   total = $total,
                   order_date = '$order_date',
                   status = '$status',
                   customer_name = '$customer_name',
                   customer_contact = '$customer_contact',
                   customer_email = '$customer_email',
                   customer_address = '$customer_address'
                   ";

                   //echo $sql2; die();
                   //ececuted the query
                   $res2 = mysqli_query($conn, $sql2);

                   //check wheather query execured successfully or not
                   if($res2==true)
                   {
                      $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                      header('location:'.SITEURL);
                   }
                   else
                   {
                    $_SESSION['order'] = "<div class='error text-center'>failed to order food.</div>";
                    header('location:'.SITEURL);
                   }


                   //validation where contact number should be only numeric values and only have max 10 digits

                   if (strlen($customer_contact) <= 10 && ctype_digit($customer_contact)) {
                    // Phone number is valid
                    echo "Phone number is valid: $customer_contact";
                } else {
                    // Phone number is invalid
                    echo "Invalid phone number. Please enter a numeric phone number with no more than 10 digits.";
                }
                
               }
               
               

               
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>