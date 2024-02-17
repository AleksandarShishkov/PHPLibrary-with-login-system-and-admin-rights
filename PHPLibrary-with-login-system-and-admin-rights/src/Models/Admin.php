<?php

require_once __DIR__ . "/../db_ini.php";

class Admin {

    protected $user_id;
    protected $book_id;
    protected $user_name;
    protected $result = [];

    public function allowUserAccess() {
        
        $activate_profile = false;

        isset($_GET['user_id_allow']) ? $this->user_id = $_GET['user_id_allow'] : $this->user_id = '';
        
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $find_user = "SELECT first_name, active 
                      FROM users 
                      WHERE id = '$this->user_id'";

        $user = $conn->query($find_user);

        if($user->num_rows > 0) {
            $record = $user->fetch_assoc();
            $this->user_name = $record['first_name'];

            if($record['active'] == 0) {
                $allow_acces = "UPDATE users 
                                SET active = '1' 
                                WHERE id = '$this->user_id'";

                $update = $conn->query($allow_acces);

                if($update) {
                    $activate_profile = true;
                } 
            }
        } else {
            $_SESSION['error_message'] = 'No such user in the database!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        }

        $conn->close();
        $this->result['activate_profile'] = $activate_profile;
        $this->result['user_name'] = $this->user_name;
        return $this->result;
        
    }

    public function rejectUserAccess() {
        
        $reject_profile = false;

        isset($_GET['user_id_reject']) ? $this->user_id = $_GET['user_id_reject'] : $this->user_id = '';

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection faled: ' . $conn->connect_error);
        }

        $find_user = "SELECT first_name, active 
                      FROM users 
                      WHERE id = '$this->user_id'";

        $user = $conn->query($find_user);

        if($user->num_rows > 0) {
            $record = $user->fetch_assoc();
            $this->user_name = $record['first_name'];

            if($record['active'] == 1) {
                $reject_access = "UPDATE users 
                                  SET active = '0' 
                                  WHERE id = '$this->user_id'";
                                  
                $update = $conn->query($reject_access);
                if($update) {
                    $reject_profile = true;
                }
            }
        } else {
            $_SESSION['error_message'] = 'No such user in the database!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        }

        $conn->close();
        $this->result['reject_profile'] = $reject_profile;
        $this->result['user_name'] = $this->user_name;
        return $this->result;
    }


    public function addBookToUsersCollection() {

        isset($_GET['admin_add_book_user_id']) ? $this->user_id = $_GET['admin_add_book_user_id'] : $this->user_id = '';
        isset($_GET['admin_add_book_id']) ? $this->book_id = $_GET['admin_add_book_id'] : $this->book_id = '';

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $find_user = "SELECT * 
                      FROM users
                      WHERE id = '$this->user_id'";

        $user = $conn->query($find_user);

        if(!$user->num_rows > 0) {
            $_SESSION['error_message'] = 'No such user in the database!';
            header('Location:src/Views/home.php');
            die();
        }

        $find_book = "SELECT *
                      FROM books
                      WHERE id = '$this->book_id'";

        $book = $conn->query($find_book);

        if(!$book->num_rows > 0) {
            $_SESSION['error_message'] = 'No such book in the library!';
            header('Location:src/Views/home.php');
            die();
        }

        $check_book_in_collection = "SELECT *
                                     FROM users_books
                                     WHERE user_id = '$this->user_id'
                                        AND book_id = '$this->book_id'";
        
        $check_book = $conn->query($check_book_in_collection);

        if($check_book->num_rows > 0) {
            $_SESSION['error_message'] = 'The book has already been added to the user`s collection!';
            header('Location:src/Views/home.php');
            die();
        }

        $sql = "INSERT INTO users_books (user_id, book_id)
                VALUES('$this->user_id', '$this->book_id')";

        $add_book = $conn->query($sql);

        if($add_book) {
            $conn->close();
            return true;
        }

        $conn->close();
        return false;
    }
}
