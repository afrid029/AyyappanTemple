<?php
 if (!isset($_COOKIE['user'])) {
    header('Location: /');
    echo "<script>window.location.pathname = '/'</script>";
    exit();
}

if(isset($_POST['submit'])){

    include("DbConnectivity.php");

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
  

    $query = "SELECT count(*) as cnt FROM events";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $randomNumber = rand(100, 999);
    $ID = 'event'. $row['cnt'] . $randomNumber;

    $query = "INSERT INTO events VALUE('$ID', '$title', '$description', '$date', '$time')";
    $result = mysqli_query($db, $query);
    
    if($result){
        echo json_encode([
            'status' => true,
            'message' => 'Program Added Successfully'
        ]);

        mysqli_close($db);

        exit();
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Unable to add Program. try again later'
        ]);

        mysqli_close($db);
        exit();
    }

} elseif (isset($_POST['edit-submit'])) {
    include("DbConnectivity.php");

    $ID = $_POST['event-id'];
    $title = $_POST['edit-title'];
    $description = $_POST['edit-description'];
    $date = $_POST['edit-date'];
    $time = $_POST['edit-time'];

    $query = "UPDATE events 
    set title = '$title',
    description = '$description',
    date = '$date',
    time = '$time'
    where ID = '$ID'";
    $result = mysqli_query($db, $query);
    
    if($result){
        echo json_encode([
            'status' => true,
            'message' => 'Program Updated Successfully'
        ]);

        mysqli_close($db);

        exit();
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Unable to Update Program. try again later'
        ]);

        mysqli_close($db);
        exit();
    }
} elseif(isset($_POST['del-submit'])){
    include('DbConnectivity.php');

    $ID = $_POST['ID'];

    $query = "DELETE from events where ID = '$ID'";
    $result = mysqli_query($db, $query);

    if($result){

        mysqli_close($db);
         echo json_encode([
            'status' => true,
            'message' => 'Program Deleted Successfully'
        ]);

        exit();

    } else {
        mysqli_close($db);
         echo json_encode([
            'status' => false,
            'message' => 'Unable to delete. Try again later'
        ]);
        exit();

    }
}

?>