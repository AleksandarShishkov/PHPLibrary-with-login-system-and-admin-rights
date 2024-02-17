<?php

require_once 'config.php';
    
    $conn = new mysqli(HOST, USERNAME, PASSWORD);

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_db = 'CREATE DATABASE IF NOT EXISTS '. DBNAME;
    if($conn->query($sql_db) != true) {
        die("Unable to create db: " . DBNAME);
    }

    $conn->close();
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $usersTable = "CREATE TABLE IF NOT EXISTS users (
                   id INT(11) AUTO_INCREMENT PRIMARY KEY,
                   first_name VARCHAR(255) NOT NULL,
                   last_name VARCHAR(255) NOT NULL,
                   email VARCHAR(255) NOT NULL,
                   password VARCHAR(255) NOT NULL,
                   active BOOL NOT NULL DEFAULT 0
    )";

    if ($conn->query($usersTable) != true) {
        die("Unable to create table 'users'");
    }


    $adminsTable = "CREATE TABLE IF NOT EXISTS administrators (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    first_name VARCHAR(255) NOT NULL,
                    last_name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL
    )";

    if ($conn->query($adminsTable) != true) {
        die("Unable to create table 'administrators'");
    }

    $check_admin = "SELECT * 
                    FROM administrators 
                    WHERE email = 'admin@xs.com'";

    $record_admin = $conn->query($check_admin);

    if($record_admin->num_rows < 1) {
        $admin_pass = password_hash('123456', PASSWORD_DEFAULT);
        $admin_record = "INSERT INTO administrators (first_name, last_name, email, password)
                         VALUES ('admin', 'admin', 'admin@xs.com', '$admin_pass')";
    
    
        $record = $conn->query($admin_record);
        if($record != true) {
            die("Unable to create the default admin record!");
        }
    }


    $booksTable = "CREATE TABLE IF NOT EXISTS books(
                   id INT(11) AUTO_INCREMENT PRIMARY KEY,
                   name VARCHAR(255) NOT NULL,
                   ISBN VARCHAR(255) NOT NULL,
                   description VARCHAR(255) NOT NULL
    )";

    if ($conn->query($booksTable) != true) {
        die("Unable to create table 'books'");
    }


    $users_booksTable = "CREATE TABLE IF NOT EXISTS users_books(
                         id INT(11) AUTO_INCREMENT PRIMARY KEY,
                         user_id INT(11) NOT NULL,
                         book_id INT(11) NOT NULL,
                         FOREIGN KEY(user_id) REFERENCES users(id),
                         FOREIGN KEY(book_id) REFERENCES books(id)
    )";

    if($conn->query($users_booksTable) != true) {
        die("Unable to create table 'users_books'");
    }

    $conn->close();
