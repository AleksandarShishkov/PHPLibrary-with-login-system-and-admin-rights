<?php

require_once __DIR__ . "/../db_ini.php";

class Book {

    protected $name;
    protected $ISBN;
    protected $description;
    protected $book_id;

    public function create() {
                
        $this->name = $_POST['name'];
        $this->description = $_POST['description'];

        $isbn_digits = 0;
        for($i = 0; $i < strlen($_POST['ISBN']); $i++) {
            if(!is_numeric($_POST['ISBN'][$i]) && $_POST['ISBN'][$i] != '-') {
                $_SESSION['error_message'] = 'Invalid ISBN. The code should contain only digits and hyphens!';
                header('Location:src/Views/Books/create.php');
                die();
            }

            if(is_numeric($_POST['ISBN'][$i])) {
                $isbn_digits++;
            }
        }

        if($isbn_digits != 13) {
            $_SESSION['error_message'] = 'The ISBN should contain 13 digits.';
            header('Location:src/Views/Books/create.php');
            die();
        }

        $this->ISBN = $_POST['ISBN'];
        
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $check_book = "SELECT * 
                       FROM books 
                       WHERE ISBN = '$this->ISBN'";
        
        $validate_book = $conn->query($check_book);

        if($validate_book->num_rows > 0) {
            $conn->close();
            $_SESSION['error_message'] = 'The book is already in the library!';
            header('Location:src/Views/Books/create.php');
            die();
        }

        $sql = "INSERT INTO books (name, ISBN, description)
                VALUES('$this->name', '$this->ISBN', '$this->description')";

        $add_book = $conn->query($sql);
        if($add_book) {
            $conn->close();
            return true;
        }

        $conn->close();
        return false;
    }   


    public function edit() {
        
        isset($_SESSION['book_id']) ? $this->book_id = $_SESSION['book_id'] : $this->book_id = '';

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $find_book = "SELECT * 
                      FROM books 
                      WHERE id = '$this->book_id'";

        $book = $conn->query($find_book);

        if($book->num_rows > 0) {
            $record = $book->fetch_assoc();

            $this->name = $_POST['edit_name'];
            $this->description = $_POST['edit_description'];

            $isbn_digits = 0;
            for($i = 0; $i < strlen($_POST['edit_ISBN']); $i++) {
                if(!is_numeric($_POST['edit_ISBN'][$i]) && $_POST['edit_ISBN'][$i] != '-') {
                    $_SESSION['error_message'] = 'Invalid ISBN. The code should contain only digits and hyphens! (978-0-13-601970-1)';
                    header('Location:src/Views/home.php');
                    die();
                }

                if(is_numeric($_POST['edit_ISBN'][$i])) {
                    $isbn_digits++;
                }
            }

            if($isbn_digits != 13) {
                $_SESSION['error_message'] = 'The ISBN should contain 13 digits. (978-0-13-601970-1)';
                header('Location:src/Views/home.php');
                die();
            }

            $this->ISBN = $_POST['edit_ISBN'];

            if($this->name == $record['name'] && $this->ISBN == $record['ISBN'] && $this->description == $record['description']) {
                $_SESSION['error_message'] = 'Nothing to update!';
                header('Location:src/Views/home.php');
                die();
            }

            $check_duplicate = "SELECT ISBN
                                FROM books
                                WHERE ISBN = '$this->ISBN'
                                    AND id != '$this->book_id'";

            $duplicate = $conn->query($check_duplicate);

            if($duplicate->num_rows > 0) {
                $_SESSION['error_message'] = 'There is another book with the same ISBN in the library. Check the details!';
                header('Location:src/Views/home.php');
                die();
            }

            $sql = "UPDATE books 
                    SET name = '$this->name', ISBN = '$this->ISBN', description = '$this->description'
                    WHERE id = '$this->book_id'";

            $edit_record = $conn->query($sql);

            if($edit_record) {
                $conn->close();
                return true;
            }
        }

        $conn->close();
        return false;
    }
}