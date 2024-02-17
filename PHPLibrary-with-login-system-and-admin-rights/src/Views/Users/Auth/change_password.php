<?php 
require_once "../../inc/header.php"; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['user_id'])) {

?>

    <h1 class="header_h1">Change your password</h1>

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
                
                <label for="current_password">Current password:</label><br>
                <input type="password" name="current_password" id="current_password" required><br><br>


                <label for="new_password">New password:</label><br>
                <input type="password" name="new_password" id="new_password" required><br><br>

                <label for="re_new_password">Re-type new password:</label><br>
                <input type="password" name="re_new_password" id="re_new_password" required><br><br>

                <input type="submit" class="submit_btn" name="change_password" value="Change password">
            </form>
        </div>
        
        <div class="back_btn_div">
            <a href="../edit.php"><button class="back_btn">Back</button></a>
        </div>

<?php 
    } else { ?>
        <h1 class="helper_text">You should log into your profile first!</h1>
<?php }

    require_once "../../inc/footer.php"; 
?>