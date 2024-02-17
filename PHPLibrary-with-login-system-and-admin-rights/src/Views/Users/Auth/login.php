<?php 
require_once "../../inc/header.php"; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

    <script>
        localStorage.removeItem("savedFirstName");
        localStorage.removeItem("savedLastName");
        localStorage.removeItem("savedEmail");
    </script>

    <h1 class="header_h1">Login page</h1>

    <div class="message_div">
        <?php 
            if(!empty($_SESSION['success_message'])) {
                echo "<h4 class='success_message'>" . $_SESSION['success_message'] . "</h4><br>";
                $_SESSION['success_message'] = null;
            } elseif(!empty($_SESSION['error_message'])) {
                echo "<h4 class='error_message'>" . $_SESSION['error_message'] . "</h4><br>";
                $_SESSION['error_message'] = null;
            } else {
                echo "<h4>Log in with your credentials!</h4><br>";
            }
        ?>
    </div>

        <div>            
            <form class="form_style" method="POST" action="../../../../index.php">
                <label for="login_email">Email:</label><br>
                <input type="email" name="email" id="login_email"><br><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password"><br><br>

                <div style="height: 5vh;">
                    Don`t have an account, <a href="../Auth/register.php">register</a>!
                </div>

                <input type="submit" class="submit_btn" name="login_user" value="Login">
            </form>
            </div>
            <div class="back_btn_div">
            <a href="../../home.php"><button class="back_btn">Back</button></a>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var email = document.getElementById('login_email');

        email.value = localStorage.getItem('savedLoginEmail') || '';

        document.getElementById('login_email').addEventListener('input', function() {
            localStorage.setItem('savedLoginEmail', this.value);
        });
    });
</script>

<?php 
    require_once "../../inc/footer.php"; 
?>