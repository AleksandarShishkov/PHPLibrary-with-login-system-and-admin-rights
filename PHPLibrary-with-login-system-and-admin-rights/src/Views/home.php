<?php 
    require_once "inc/header.php";     
?>

    <script>
        localStorage.removeItem("savedName");
        localStorage.removeItem("savedISBN");
        localStorage.removeItem("savedDescription");
        localStorage.removeItem("savedLoginEmail");
    </script>

    <div class="message_div">
        <?php
            if(!empty($_SESSION['success_message'])) {
                echo "<h4 class='success_message'>" . $_SESSION['success_message'] . "</h4><br>";
                $_SESSION['success_message'] = null;
            } elseif(!empty($_SESSION['error_message'])) {
                echo "<h4 class='error_message'>" . $_SESSION['error_message'] . "</h4><br>";
                $_SESSION['error_message'] = null;
            }
        ?>
    </div> 

    <?php 
        if(isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])) { ?>
            <h1 class="header_h1">View all books</h1>

            <div>
                <?php
                include('Books/index.php');
                ?>
            </div>
        <?php } else { ?>
            <h1 class="header_h1">Home page</h1>
        <?php } ?>

    <div class="home_btn_div">
        <?php if(isset($_SESSION['admin_id'])) {?>

            <div>
                <a href="Admins/manage_users.php"><button class="home_btn">Manage users</button></a>
                <a href="Books/create.php"><button class="home_btn">Create Book</button></a>
            </div>
        <?php } else if(isset($_SESSION['user_id'])) {?>

            <div>
                <a href="Users/my_books_collection.php"><button class="home_btn">My books</button></a>
                <a href="Users/edit.php"><button class="home_btn">Edit Profile</button></a>
            </div>

        <?php } else { ?>
            <div>
                <a href="Users/Auth/login.php"><button class="home_btn">Login</button></a>
                <a href="Users/Auth/register.php"><button class="home_btn">Register</button></a>
            </div>
        <?php } ?>

    </div>

<?php 
    require_once "inc/footer.php"; 
?>