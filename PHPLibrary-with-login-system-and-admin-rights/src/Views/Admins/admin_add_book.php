<?php 

require_once '../inc/header.php';
require_once '../../db_ini.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if(isset($_SESSION['admin_id'])) {

        isset($_GET['book_id']) ? $book_id = $_GET['book_id'] : $book_id = '';
        isset($_GET['book_name']) ? $book_name = $_GET['book_name'] : $book_name = 'the book';

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $get_all_users = "SELECT * 
                          FROM users";
                          
        $users = $conn->query($get_all_users);

        if($users->num_rows > 0) {
            echo '<h1 class="header_h1">Add ' . "'$book_name'" . ' to user</h1>';

            if(!empty($_SESSION['success_message'])) {
                echo "<h4 class='success__message'>" . $_SESSION['success_message'] . "</h4><br>";
                $_SESSION['success_message'] = null;
            } elseif(!empty($_SESSION['error_message'])) {
                echo "<h4 class='error_message'>" . $_SESSION['error_message'] . "</h4><br>";
                $_SESSION['error_message'] = null;
            }

        ?>
            <div class="table_div">
            <table>
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    <?php while($user = $users->fetch_assoc()) {?>                
                    <tr>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <?php
                                if($user['active']) {
                                    echo '<span style="color:green">Active</span>';
                                } else {
                                    echo '<span style="color:red">Inactive</span>';
                                }
                            ?>

                        </td>
                        <td>
                            <div class="action_btn_container_div">
                                <a href="../../../index.php?admin_add_book_user_id=<?= $user['id'] ?>&admin_add_book_id=<?= $book_id ?>">
                                    <button class="admin_add_book_to_collection">Add book to collection</button>
                                </a>
                            </div>
                        </td>
                    </tr>
        <?php } ?>
    </tbody>
</table>

            </div>
            <div class="back_btn_div">
                <a href="../home.php"><button class="back_btn">Back</button></a>
            </div>

        <?php
        } else { ?>
            <div>
                <h1 class='helper_text'>No user profiles detected!</h1>
            </div>
            <div class='back_btn_div'>
                <a href='../home.php'><button class='back_btn'>Back</button></a>
            </div>";
        <?php }
    
 } else { ?>
    <h1 class="helper_text">You should have admin rights to add a book!</h1>

    <div class='back_btn_div'>
        <a href='../home.php'><button class='back_btn'>Back</button></a>
    </div>";
<?php } ?>

<?php 
    require_once '../inc/footer.php'; 
?>

