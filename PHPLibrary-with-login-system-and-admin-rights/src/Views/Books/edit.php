<?php 

require_once '../../db_ini.php';
require_once '../inc/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if(isset($_SESSION['admin_id'])) {

        isset($_GET['book_id']) ? $book_id = $_GET['book_id'] : $book_id = '';
        $_SESSION['book_id'] = $book_id;
        
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
    
        $find_book = "SELECT * 
                      FROM books 
                      WHERE id = '$book_id'";
                      
        $book = $conn->query($find_book);
    
        if($book->num_rows > 0) {
            $record = $book->fetch_assoc(); 
        } else {
            $_SESSION['error_message'] = 'No book located.';
            header('Location:../home.php');
            die();
        }
?>

<h1 class="header_h1">Edit Book</h1>

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

        <input type="hidden" name="book_id" value="<?=$book_id?>">

        <label for="edit_name">Name:</label><br>
        <input type="text" name="edit_name" id="edit_name" value="<?= $record['name'] ?>"><br><br>

        <label for="edit_ISBN">ISBN:</label><br>
        <input type="text" name="edit_ISBN" id="edit_ISBN" value="<?= $record['ISBN'] ?>"><br><br>

        <label for="edit_description">Description:</label><br>
        <textarea name="edit_description" id="edit_description" rows="5" required><?=$record['description']?></textarea><br><br>


        <input type="submit" class="submit_btn" name="edit_book" value="Edit book">
    </form>

</div>
<div class="back_btn_div">
    <a href="../home.php"><button class="back_btn">Back</button></a>
</div>


<?php } else { ?>

    <h1 class="helper_text">You should have admin rights to edit the book information!</h1>
<?php } ?>



<?php require_once '../inc/footer.php'; ?>