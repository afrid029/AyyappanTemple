<?php
// Get the current URL path
$request = $_SERVER['REQUEST_URI'];
$request = explode('?', $request)[0];
// print_r(explode('?', $request)[0]);

// echo $request.implode('?');

// echo $request;

// exit();


// Define routes
switch ($request) {
    case '/':
        require 'index.php';  // Home page
        break;
    case '/loginpage':
        require 'Pages/Login.php';  
    break;
    case '/login':
        require 'Controllers/login.php';  
    break;
    case '/logout':
        require 'Controllers/logoff.php';
    break;
    case '/dashboard':
        require 'dashboard.php';
        break;
    case '/calendar':
        require 'calendar.php';
        break;
    case '/gallery':
        require 'gallery.php';
        break;
    default:
        http_response_code(404); // Not Found
        // require 'error.php';
        break;
}

?>
