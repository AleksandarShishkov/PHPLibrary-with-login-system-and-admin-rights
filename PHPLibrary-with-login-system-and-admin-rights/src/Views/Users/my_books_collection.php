<?php 
    
    require_once '../../db_ini.php';
    require_once '../inc/header.php';


    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    if($conn->connect_error) {
        die('Connection failed: ' . $conn->connection_failed);
    }

    isset($_SESSION['user_id']) ? $user_id = $_SESSION['user_id'] : $user_id = '';

    if($_SESSION['user_id'] != '') {
    
        $find_books = "SELECT b.id, b.name, b.ISBN, b.description 
                    FROM books AS b
                            RIGHT JOIN users_books AS ub
                                ON b.id = ub.book_id
                            JOIN users AS u
                                ON u.id = ub.user_id
                    WHERE u.id = '$user_id' 
                            ORDER BY b.id";

        $books = $conn->query($find_books);

?>

<h1 class="header_h1">My books</h1>

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
    <?php if($books->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ISBN</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($book = $books->fetch_assoc()) {?>                
                    <tr>
                        <td><?= $book['name'] ?></td>
                        <td><?= $book['ISBN'] ?></td>
                        <td><?= $book['description'] ?></td>
                        <td>
                            <div class="index_product_buttons">
                                <?php if(isset($_SESSION['user_id'])) { ?>
                                    <a href="../../../index.php?remove_book_id=<?= $book['id'] ?>"><button class="remove_book_from_collection_btn">Remove book</button></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } 
        } else { ?>
            <tr>
                <td colspan="5"><h4 class="helper_text">No books in your collection.</h4></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</div>
    <div class="back_btn_div">
        <a href="../home.php"><button class="back_btn">Back</button></a>
    </div>
</div>

<?php } else { ?>
    <div>
        <h1 class="helper_text">You should log into your user profile first!</h1>
    </div>
<?php }

    require_once '../inc/footer.php';
?>