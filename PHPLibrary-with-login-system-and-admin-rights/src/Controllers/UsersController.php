<?php

require_once __DIR__ . '/../Models/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UsersController {

    protected $userModel;
    protected $login;
    protected $register;
    protected $edit;
    protected $change_password;
    protected $add_book;
    protected $my_collection;

    public function __construct() {
        $this->userModel = new User();
    }


    public function _login() {
        $this->login = $this->userModel->login();
        if($this->login) {
            $_SESSION['success_message'] = 'You have logged into your profile!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Invalid credentials!';
            header('Location:src/Views/Users/Auth/login.php');
            die();
        }
    }


    public function _register() {
        $this->register = $this->userModel->register();
        if($this->register) {
            $_SESSION['success_message'] = 'You have registered your profie. Wait for the admin to allow your access!';
            header('Location:src/Views/Users/Auth/login.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Location:src/Views/Users/Auth/register.php');
            die();
        }
    }


    public function _edit() {        
        $this->edit = $this->userModel->edit();
        
        if($this->edit) {
            $_SESSION['success_message'] = 'Your profile has been updated successfully!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_messsage'] = 'Something went wrong. Try again!';
            header('Location:src/Views/Users/edit.php');
            die();
        }
    }

    public function _changePassword() {
        $this->change_password = $this->userModel->changePassword();

        if($this->change_password) {
            $_SESSION['success_message'] = 'You have changed your password. Log in with the new credentials!';
            header('Location:src/Views/Users/Auth/logout.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Location:src/Views/Users/Auth/change_password.php');
            die();
        }
    }

    
    public function _addBookToCollection() {
        $this->add_book = $this->userModel->addBookToCollection();

        if($this->add_book) {
            $_SESSION['success_message'] = 'The book has been added to your collection!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Location":src/Views/home.php');
            die();
        }
    }


    public function _removeBookFromCollection() {
        $this->remove_book = $this->userModel->removeBookFromCollection();

        if($this->remove_book) {
            $_SESSION['success_message'] = 'The book has been removed from the collection!';
            header('Location:src/Views/Users/my_books_collection.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong!';
            header('Location:src/Views/Users/my_books_collection.php');
            die();
        }
    }
}
