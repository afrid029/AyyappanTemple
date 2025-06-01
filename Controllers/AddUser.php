<?php
  if (!isset($_COOKIE['user'])) {
            header('Location: /');
            echo "<script>window.location.pathname = '/'</script>";
            exit();
        }

    if(isset($_POST['submit'])){
      
      
        include('DbConnectivity.php');

        $query = "SELECT count(*) as cnt FROM users";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);

        $randomNumber = rand(100, 999);
        $ID = 'user'. $row['cnt'] . $randomNumber;


        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = 'Admin';

        $query = "INSERT INTO users value('$ID','$email', '$password', true, '$role')";
        $result = mysqli_query($db, $query);

        if($result) {
            // $_SESSION['message'] = "Failed to upload Images. Try again later!";
            // $_SESSION['status'] = false;
            // $_SESSION['fromAction'] = true;
            mysqli_close($db);

            echo json_encode([
                'status' => true,
                'message' => 'Admin Created Successfully!'
            ]);
        }

        else {
            $message = mysqli_error($db);
            mysqli_close($db);
            echo json_encode([
                'status' => false,
                'message' => $message
            ]);
        }
    } elseif($_POST['edit-submit']) {
        // if (!isset($_COOKIE['user'])) {
        //     header('Location: /');
        //     echo "<script>window.location.pathname = '/'</script>";
        //     exit();
        // }
      
        include('DBConnectivity.php');


        $username = $_POST['userid'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $active = $_POST['active'];

        // var_dump($_POST);
        // exit();

        $query = "UPDATE users set email='$email', password = '$password', status = $active  WHERE ID = '$username'";
        $result = mysqli_query($db, $query);

        if($result) {
            // $_SESSION['message'] = "Failed to upload Images. Try again later!";
            // $_SESSION['status'] = false;
            // $_SESSION['fromAction'] = true;
            mysqli_close($db);

            echo json_encode([
                'status' => true,
                'message' => 'User information updated Successfully!'
            ]);
        }

        else {
            $message = mysqli_error($db);
            mysqli_close($db);
            echo json_encode([
                'status' => false,
                'message' => $message
            ]);
        }
    } else {
        header('Location: /');
        echo "<script>window.location.pathname = '/'</script>";
        exit();
    }

?>