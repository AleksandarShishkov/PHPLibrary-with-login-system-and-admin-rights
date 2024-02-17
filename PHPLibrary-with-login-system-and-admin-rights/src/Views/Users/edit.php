<?php 

require_once '../../db_ini.php';
require_once '../inc/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if(isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
    
        $find_user = "SELECT * 
                      FROM users 
                      WHERE id = '$user_id'";
                      
        $user = $conn->query($find_user);
    
        if($user->num_rows > 0) {
            $record = $user->fetch_assoc(); 
        } else {
            $_SESSION['error_message'] = 'No such user located.';
            header('Location:../home.php');
            die();
        }
?>

<h1 class="header_h1">Edit profile</h1>

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
    <form class="form_style" method="POST" action="../../../index.php">

        <label for="edit_first_name">First name:</label><br>
        <input type="text" name="edit_first_name" id="edit_first_name" value="<?= $record['first_name'] ?>"><br><br>

        <label for="edit_last_name">Last name:</label><br>
        <input type="text" name="edit_last_name" id="edit_last_name" value="<?= $record['last_name'] ?>"><br><br>

        <label for="edit_email">Email:</label><br>
        <input type="text" name="edit_email" id="edit_email" value="<?= $record['email'] ?>"><br><br>

        <input class="submit_btn" type="submit" name="edit_profile" value="Edit profile">
    </form>
</div>

<div class="change_password_div">
    <a href="Auth/change_password.php"><button class="change_password_btn">Change password</button></a>
</div>

<div class="back_btn_div">
    <a href="../home.php"><button class="back_btn">Back</button></a>
</div>


<?php } else { ?>
    <div>
        <h1 class="helper_text">You should log into your profile first!</h1>
    </div>
<?php } 

    require_once '../inc/footer.php'; 
?>
