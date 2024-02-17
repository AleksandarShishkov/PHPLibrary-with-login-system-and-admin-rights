<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHP Library</title>

        <?php
           $current_page = basename($_SERVER['REQUEST_URI']);

           $request_uri = $_SERVER['REQUEST_URI'];
           $remove_parts = explode('/', $request_uri);
           foreach($remove_parts as $part) {
             if($part == 'src') {
               $uri[] = $part;
               break;
             }
             $uri[] = $part;
           }
 
           $base_uri = implode('/', $uri);
        ?>

        <link rel="stylesheet" type="text/css" href="<?=$base_uri . '/Public/style.css'?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
        <?php         
            if(isset($_SESSION['admin_id'])) { 
          ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'home.php') echo 'active'; ?>" aria-current="page" href="<?=$base_uri . '/Views/home.php'?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'manage_users.php') echo 'active'; ?>" href="<?=$base_uri . '/Views/Admins/manage_users.php'?>">Manage users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'create.php') echo 'active'; ?>" href="<?=$base_uri . '/Views/Books/create.php'?>">Create book</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              LogOut
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="<?=$base_uri . '/Views/Users/Auth/logout.php'?>">LogOut</a></li>
            </ul>
          </li>
        <?php } else if(isset($_SESSION['user_id'])) { 
          ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'home.php') echo 'active'; ?>" aria-current="page" href="<?=$base_uri . '/Views/home.php'?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'my_books_collection.php') echo 'active'; ?>" href="<?=$base_uri . '/Views/Users/my_books_collection.php'?>">My books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'edit.php') echo 'active'; ?>" href="<?=$base_uri . '/Views/Users/edit.php'?>">Edit profile</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              LogOut
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="<?=$base_uri . '/Views/Users/Auth/logout.php'?>">LogOut</a></li>
            </ul>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'home.php') echo 'active'; ?>" aria-current="page" href="<?=$base_uri . '/Views/home.php'?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'login.php') echo 'active'; ?>" aria-current="page" href="<?=$base_uri . '/Views/Users/Auth/login.php'?>">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page == 'register.php') echo 'active'; ?>" href="<?=$base_uri . '/Views/Users/Auth/register.php'?>">Register</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
    <body style="background-color:	rgba(255, 165, 0, 0.8);">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
