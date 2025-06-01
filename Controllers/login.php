<?php 
if(isset($_POST['submit'])){
    SESSION_START();
    $username = $_POST['email'];
    $password = $_POST['password'];


    include('DbConnectivity.php');

    $query = "SELECT * from users WHERE email = '$username' and status = true";
    $result = mysqli_query($db, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

       
            if($row['password'] === $password) {

                $data = [
                    'email' => $row['email'],
                    'role' => $row['role']
                ];
    
                $iv = openssl_random_pseudo_bytes(16);  // AES block size is 16 bytes
    
                // Encrypt the email using AES-256-CBC encryption
                    $key = 'i3vWrGxR4KiBaKfPbqwnb8U7KjN4MGvq0duG2dXs/Xc=';
                    $encryptedData = openssl_encrypt(serialize($data), 'aes-256-cbc', $key, 0, $iv);
                
                    // Combine the IV with the encrypted email to store both together
                    $encryptedWithWithIv = base64_encode($iv . $encryptedData);
        
                    setcookie('user', $encryptedWithWithIv, time() + 21600, '/');
        
                    $_SESSION['isLoggedIn'] = true;

                    $_SESSION['fromAction'] = true;
                    $_SESSION['message'] = 'Log in Successfull';
                    $_SESSION['status'] = true;
    
                    mysqli_close($db);
                    header('Location: /dashboard');
                    exit();
                    
             
            }else {
                $_SESSION['fromAction'] = true;
                $_SESSION['message'] = 'Entered Password is wrong';
                $_SESSION['status'] = false;
                mysqli_close($db);
                header('Location: /');
                exit();
            }
        
        


    }else {
        $_SESSION['fromAction'] = true;
        $_SESSION['message'] = 'Email not found! / Access Revoked';
        $_SESSION['status'] = false;
        mysqli_close($db);
        header('Location: /');
        exit(); 
    }
} else {
        header('Location: /');
        echo "<script>window.location.pathname = '/'</script>";
        exit();
    }
?>