<?php

require_once __DIR__ . "/../db_ini.php";

class User {

    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $new_password;
    protected $book_id;
    protected $user_id;

    public function login() {

        $this->email = $_POST['email'];
        $this->password = $_POST['password'];

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $admin_credentials = "SELECT id, password 
                              FROM administrators 
                              WHERE email = '$this->email'";

        $validate_credentials = $conn->query($admin_credentials);

        if($validate_credentials->num_rows > 0) {
            $record = $validate_credentials->fetch_assoc();

            if(password_verify($this->password, $record['password'])) {
                $_SESSION['admin_id'] = $record['id'];
                $conn->close();
                return true;
            }
        } 

        $user_credentials = "SELECT id, password, active 
                             FROM users 
                             WHERE email = '$this->email'";

        $validate_credentials = $conn->query($user_credentials);
    
        if($validate_credentials->num_rows > 0) {
            $record = $validate_credentials->fetch_assoc();
    
            if(password_verify($this->password, $record['password'])) {
                if($record['active']) {
                    $_SESSION['user_id'] = $record['id'];
                    $conn->close();
                    return true;
                } else {
                    $_SESSION['error_message'] = 'Your profile wasn`t activated yet. Allow more time!';
                    header('Location:src/Views/home.php');
                    die();
                }
            }
        }
            
        $conn->close();
        return false;
    }


    public function register() {

        $this->first_name = $_POST['first_name'];
        $this->last_name = $_POST['last_name'];
        $this->email = $_POST['email'];

        if($_POST['password'] != $_POST['confirm_password']) {
            $_SESSION['error_message'] = 'The passwords didn`t match!';
            header('Location:src/Views/Users/Auth/register.php');
            die();
        }

        $this->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $check_credentials = "SELECT id 
                              FROM users 
                              WHERE email = '$this->email'";

        $validate = $conn->query($check_credentials);

        if($validate->num_rows > 0) {
            $_SESSION['error_message'] = 'User with the same email address has been registered!';
            header('Location:src/Views/Users/Auth/register.php');
            die();
        }

        $sql = "INSERT INTO users (first_name, last_name, email, password) 
                       VALUES('$this->first_name', '$this->last_name', '$this->email', '$this->password')";

        $register_user = $conn->query($sql);
        if($register_user) {
            $conn->close();
            return true;
        }

        $conn->close();
        return false;
    }


    public function edit() {

        isset($_SESSION['user_id']) ? $this->user_id = $_SESSION['user_id'] : $this->user_id = '';

        $this->first_name = $_POST['edit_first_name'];
        $this->last_name = $_POST['edit_last_name'];
        $this->email = $_POST['edit_email'];

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $find_user = "SELECT first_name, last_name, email
                      FROM users
                      WHERE id = '$this->user_id'";

        $user = $conn->query($find_user);

        if($user->num_rows > 0) {
            $record = $user->fetch_assoc();

            if($this->first_name == $record['first_name'] && $this->last_name == $record['last_name'] && $this->email == $record['email']) {
                $_SESSION['error_message'] = 'Your credentials are already up to date!';
                header('Location:src/Views/Users/edit.php');
                die();
            }
        } else {
            $_SESSION['error_message'] = 'No such user in the databse!';
            header('Location:src/Views/home.php');
            die();
        }

        $edit_user = "UPDATE users 
                      SET first_name = '$this->first_name', last_name = '$this->last_name', email = '$this->email'
                      WHERE id = $this->user_id";

        $edit_profile = $conn->query($edit_user);

        if($edit_profile) {
            $conn->close();
            return true;
        }

        $conn->close();
        return $edit;
    }


    public function changePassword() {

        isset($_SESSION['user_id']) ? $this->user_id = $_SESSION['user_id'] : $this->user_id = '';
        $this->password = $_POST['current_password'];
        
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $check_user_pass = "SELECT password
                            FROM users
                            WHERE id = '$this->user_id'";

        $check_user = $conn->query($check_user_pass);

        if($check_user->num_rows > 0) {
            $reg_password = $check_user->fetch_assoc();

            if(password_verify($this->password, $reg_password['password'])) {
                
                if($_POST['new_password'] == $_POST['re_new_password']) {
                    
                    if(password_verify($_POST['new_password'], $reg_password['password'])) {
                        $_SESSION['error_message'] = 'Nothing to change. We already have your password!';
                        header('Location:src/Views/Users/edit.php');
                        die();
                    }
                    
                    $this->new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                    $sql = "UPDATE users
                            SET password = '$this->new_password'
                            WHERE id = '$this->user_id'";

                    $change_password = $conn->query($sql);

                    if($change_password) {
                        $conn->close();
                        return true;
                    }

                } else {
                    $_SESSION['error_message'] = 'The new passwords didn`t match!';
                    header('Location:src/Views/Users/Auth/change_password.php');
                    die();
                }
            } else {
                $_SESSION['error_message'] = 'Invalid current passwod. Check your credentials!';
                header('Location:src/Views/Users/Auth/change_password.php');
                die();
            }
        } else {
            $_SESSION['error_message'] = 'No such user in the database!';
            header('Location:src/Views/Users/Auth/change_password.php');
            die();
        }

        $conn->close();
        return false;
    }


    public function addBookToCollection() {
        
        isset($_GET['add_book_id']) ? $this->book_id = $_GET['add_book_id'] : $this->book_id = '';
        isset($_SESSION['user_id']) ? $this->user_id = $_SESSION['user_id'] : $this->user_id = '';

        $added_book = [];

        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $book_query = "SELECT * 
                       FROM users_books 
                       WHERE user_id = '$this->user_id' 
                            AND book_id = '$this->book_id'";

        $check_book = $conn->query($book_query);

        if($check_book->num_rows > 0) {
            $conn->close();
            $_SESSION['error_message'] = 'The book has already been added to your collection!';
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


    public function removeBookFromCollection() {

        isset($_GET['remove_book_id']) ? $this->book_id = $_GET['remove_book_id'] : $this->book_id = '';
        
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $find_book = "SELECT id 
                      FROM users_books
                      WHERE book_id = '$this->book_id'";

        $book = $conn->query($find_book);

        if($book->num_rows > 0) {
            
            $sql = "DELETE 
                    FROM users_books
                    WHERE book_id = '$this->book_id'";

            $remove_book = $conn->query($sql);
            if($remove_book) {
                $conn->close();
                return true;
            } 
        } else {
            $conn->close();
            $_SESSION['error_message'] = 'No such book in your collection.';
            header('Location:src/Views/Users/my_books_collection.php');
            die();
        }

        $conn->close();
        return false;
    }
}
