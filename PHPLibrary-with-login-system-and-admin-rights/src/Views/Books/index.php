<?php 
    require_once __DIR__ . '/../../db_ini.php';

    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

    if($conn->connect_error) {
        die('Connection failed: ' . $conn->connection_failed);
    }

    $find_books = "SELECT * 
                   FROM books";
                   
    $books = $conn->query($find_books);
?>

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
                            <div class="action_btn_container_div">
                                <?php 
                                
                                if(isset($_SESSION['admin_id'])) { ?>
                                    <a href="Books/edit.php?book_id=<?=$book['id']?>"><button class="edit_book_btn">Edit</button></a>
                                    <a href="Admins/admin_add_book.php?book_id=<?=$book['id']?>&book_name=<?=$book['name']?>"><button class="add_book_btn">Add book to user`s collection</button></a>
                                <?php } else if(isset($_SESSION['user_id'])) { ?>
                                    <a href="../../index.php?add_book_id=<?=$book['id']?>"><button class="add_book_btn">Add book to 'My books' collection</button></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } 
    } else { ?>
            <tr>
                <td colspan="5"><h4 class="helper_text">No books in the library.</h4></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
