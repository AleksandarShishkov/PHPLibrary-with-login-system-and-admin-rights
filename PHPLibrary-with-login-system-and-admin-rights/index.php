<?php

    require_once 'src/db_ini.php';
    require_once 'src/Controllers/UsersController.php';
    require_once 'src/Controllers/BooksController.php';
    require_once 'src/Controllers/AdminsController.php';
    
    $admin = new AdminsController();
    $user = new UsersController();
    $book = new BooksController();

    if(isset($_POST['register_user'])) {
        $user->_register();

    } else if(isset($_POST['login_user'])) {
        $user->_login();

    } else if(isset($_POST['edit_profile'])) {
        $user->_edit();

    } else if(isset($_POST['change_password'])) {
        $user->_changePassword();

    } else if(isset($_GET['add_book_id'])) {
        $user->_addBookToCollection();

    } else if(isset($_GET['remove_book_id'])) {
        $user->_removeBookFromCollection();

    } else if(isset($_POST['create_book'])) {
        $book->_create();

    } else if(isset($_POST['edit_book'])) {
        $book->_edit();

    } else if(isset($_GET['user_id_allow'])) {
        $admin->_allowUserAccess();

    } else if(isset($_GET['user_id_reject'])) {
        $admin->_rejectUserAccess();

    } else if(isset($_GET['admin_add_book_user_id']) && isset($_GET['admin_add_book_id'])) {
        $admin->_addBookToUsersCollection();

    } else {
        header('Location:src/Views/home.php');
        
    }
