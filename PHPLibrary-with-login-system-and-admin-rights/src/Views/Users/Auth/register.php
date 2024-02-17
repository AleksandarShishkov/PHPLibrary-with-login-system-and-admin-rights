<?php 
    require_once "../../inc/header.php"; 
?>


    <h1 class="header_h1">Register</h1>

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
    <div>
        <form class="form_style" method="POST" action="../../../../index.php">
            <label for="first_name">First Name:</label><br>
            <input type="text" name="first_name" id="first_name" required><br><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" name="last_name" id="last_name" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" requried><br><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" name="confirm_password" id="confirm_password" requried><br><br>

            <input class="submit_btn" type="submit" name="register_user" value="Register">
        </form>
    </div>
    
    <div class="back_btn_div">
        <a href="../../home.php"><button class="back_btn">Back</button></a>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var first_name = document.getElementById('first_name');
        var last_name = document.getElementById('last_name');
        var email = document.getElementById('email');

        first_name.value = localStorage.getItem('savedFirstName') || '';
        last_name.value = localStorage.getItem('savedLastName') || '';
        email.value = localStorage.getItem('savedEmail') || '';

        document.getElementById('first_name').addEventListener('input', function() {
            localStorage.setItem('savedFirstName', this.value);
        });

        document.getElementById('last_name').addEventListener('input', function() {
            localStorage.setItem('savedLastName', this.value);
        });

        document.getElementById('email').addEventListener('input', function() {
            localStorage.setItem('savedEmail', this.value);
        });
    });
</script>

<?php
    require_once "../../inc/footer.php"; 
?>
