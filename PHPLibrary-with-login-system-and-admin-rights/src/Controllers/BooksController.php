<?php

require_once __DIR__ . '/../Models/Book.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class BooksController {

    protected $bookModel;
    protected $create_book;
    protected $edit_book;

    public function __construct() {
        $this->bookModel = new Book();
    }


    public function _create() {
        $this->create_book = $this->bookModel->create();
    
        if($this->create_book) {
            $_SESSION['success_message'] = 'The book has been added to the library!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Location:src/Views/Books/create.php');
            die();
        }
    }


    public function _edit() {
        $this->edit_book = $this->bookModel->edit();      

        unset($_SESSION['book_id']);
        unset($_SESSION['book_name']);

        if($this->edit_book) {
            $_SESSION['success_message'] = 'The book details were updated!';
            header('Location:src/Views/home.php');
            die();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Try again!';
            header('Location:src/Views/home.php');
            die();
        }
    }
}
