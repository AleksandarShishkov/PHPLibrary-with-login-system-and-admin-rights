<?php

require_once __DIR__ . '/../Models/Admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AdminsController {

    protected $adminModel;
    protected $allow_access;
    protected $reject_access;
    protected $add_book_to_collection;

    public function __construct() {
        $this->adminModel = new Admin();
    }


    public function _allowUserAccess() {
        $this->allow_access = $this->adminModel->allowUserAccess();
        if($this->allow_access['activate_profile']) {
            $_SESSION['success_message'] = 'User: ' . $this->allow_access['user_name'] . ' can now log in!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Somethig went wrong with your request!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        }
    }


    public function _rejectUserAccess() {
        $this->reject_access = $this->adminModel->rejectUserAccess();

        if($this->reject_access['reject_profile']) {
            $_SESSION['error_message'] = 'User: ' . $this->reject_access['user_name'] . ' will not be able to log in from now on!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong with your request!';
            header('Location:src/Views/Admins/manage_users.php');
            die();
        }
    }


    public function _addBookToUsersCollection() {
        $this->add_book_to_collection = $this->adminModel->addBookToUsersCollection();
        
        if($this->add_book_to_collection) {
            $_SESSION['success_message'] = 'The book was added to the user`s collection!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Locatioon:src/Views/home.php');
            die();
        }
    }
}
