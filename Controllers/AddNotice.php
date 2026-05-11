<?php
if (!isset($_COOKIE['user'])) {
    header('Location: /');
    echo "<script>window.location.pathname = '/'</script>";
    exit();
}

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Assets/Images/Notices/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

function uploadNoticeImage($fileKey, $uploadDir)
{
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $mime = mime_content_type($_FILES[$fileKey]['tmp_name']);
    if (!in_array($mime, $allowed)) {
        return false;
    }
    $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
    $filename = uniqid('notice_', true) . '.' . $ext;
    $dest = $uploadDir . $filename;
    if (!move_uploaded_file($_FILES[$fileKey]['tmp_name'], $dest)) {
        return false;
    }
    return '/Assets/Images/Notices/' . $filename;
}

if (isset($_POST['submit'])) {
    include('DbConnectivity.php');

    $title = mysqli_real_escape_string($db, $_POST['notice-title']);
    $date  = mysqli_real_escape_string($db, $_POST['notice-date']);

    $tamPath = uploadNoticeImage('tamnotice', $uploadDir);
    $engPath = uploadNoticeImage('engnotice', $uploadDir);

    if ($tamPath === false || $engPath === false) {
        echo json_encode(['status' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF allowed.']);
        mysqli_close($db);
        exit();
    }
    if ($tamPath === null || $engPath === null) {
        echo json_encode(['status' => false, 'message' => 'Both Tamil and English notice images are required.']);
        mysqli_close($db);
        exit();
    }

    $query = "SELECT count(*) as cnt FROM notices";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo json_encode(['status' => false, 'message' => 'DB error: ' . mysqli_error($db)]);
        mysqli_close($db);
        exit();
    }
    $row = mysqli_fetch_assoc($result);
    $ID = 'notice' . $row['cnt'] . rand(100, 999);

    $query = "INSERT INTO notices (ID, title, date, tamnotice, engnotice) VALUES ('$ID', '$title', '$date', '$tamPath', '$engPath')";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Notice Added Successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => mysqli_error($db)]);
    }
    mysqli_close($db);
    exit();
} elseif (isset($_POST['edit-submit'])) {
    include('DbConnectivity.php');

    $ID    = mysqli_real_escape_string($db, $_POST['notice-id']);
    $title = mysqli_real_escape_string($db, $_POST['edit-notice-title']);
    $date  = mysqli_real_escape_string($db, $_POST['edit-notice-date']);

    $setParts = ["title = '$title'", "date = '$date'"];

    $tamPath = uploadNoticeImage('edit-tamnotice', $uploadDir);
    if ($tamPath === false) {
        echo json_encode(['status' => false, 'message' => 'Invalid Tamil notice file type.']);
        mysqli_close($db);
        exit();
    }
    if ($tamPath !== null) {
        $setParts[] = "tamnotice = '$tamPath'";
    }

    $engPath = uploadNoticeImage('edit-engnotice', $uploadDir);
    if ($engPath === false) {
        echo json_encode(['status' => false, 'message' => 'Invalid English notice file type.']);
        mysqli_close($db);
        exit();
    }
    if ($engPath !== null) {
        $setParts[] = "engnotice = '$engPath'";
    }

    $setClause = implode(', ', $setParts);
    $query = "UPDATE notices SET $setClause WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Notice Updated Successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => mysqli_error($db)]);
    }
    mysqli_close($db);
    exit();
} elseif (isset($_POST['del-submit'])) {
    include('DbConnectivity.php');

    $ID = mysqli_real_escape_string($db, $_POST['ID']);

    // Get file paths before deleting
    $query = "SELECT tamnotice, engnotice FROM notices WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tamFile = $_SERVER['DOCUMENT_ROOT'] . $row['tamnotice'];
        $engFile = $_SERVER['DOCUMENT_ROOT'] . $row['engnotice'];
    }

    $query = "DELETE FROM notices WHERE ID = '$ID'";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Remove uploaded files
        if (isset($tamFile) && file_exists($tamFile)) {
            unlink($tamFile);
        }
        if (isset($engFile) && file_exists($engFile)) {
            unlink($engFile);
        }
        echo json_encode(['status' => true, 'message' => 'Notice Deleted Successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => mysqli_error($db)]);
    }
    mysqli_close($db);
    exit();
} else {
    header('Location: /');
    exit();
}
