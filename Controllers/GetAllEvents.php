<?php
include('DbConnectivity.php');

$query = "SELECT *
from events Where date >= CURRENT_DATE
ORDER BY date asc, time asc";

$result = mysqli_query($db, $query);
// echo $result;

$html = '';


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data = json_encode($row);
        $html .= "
        <div class='bg-white border border-amber-100 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden'>
            <div class='bg-red-900 px-4 py-3'>
                <h3 class='text-white font-bold text-sm truncate'>" . htmlspecialchars($row['title']) . "</h3>
            </div>
            <div class='p-4 flex flex-col gap-2'>
                <div class='flex items-center gap-2 text-gray-500 text-xs'>
                    <span>" . htmlspecialchars($row['date']) . "</span>
                    <span class='text-gray-300'>&#9679;</span>
                    <span>" . htmlspecialchars($row['time']) . "</span>
                </div>
                <p class='text-gray-600 text-xs line-clamp-3'>" . htmlspecialchars($row['description']) . "</p>
                <div class='flex gap-2 mt-2'>
                    <button onclick='EditEvent($data)' class='flex-1 bg-amber-500 hover:bg-amber-400 text-white text-xs font-semibold py-2 rounded-lg transition'>Edit</button>
                    <button onclick='DeleteEvent($data)' class='flex-1 bg-red-700 hover:bg-red-600 text-white text-xs font-semibold py-2 rounded-lg transition'>Delete</button>
                </div>
            </div>
        </div>";
    }
} else {
    $html .= "<div class='col-span-3 text-center text-gray-400 text-sm py-6 font-semibold'>No upcoming events found.</div>";
}

$userHtml = "";

if ($_SESSION['role'] === 'superadmin') {
    $query = "SELECT * FROM users where role='Admin'";
    $result1 = mysqli_query($db, $query);



    while ($row = mysqli_fetch_assoc($result1)) {
        $class = $row['status'] ? 'active-status' : 'deactive-status';
        $staus = $row['status'] ? 'Active' : 'Disabled';
        $data = [
            'ID' => $row['ID'],
            'email' => $row['email'],
            'role' => $row['role'],
            'status' => $row['status']
        ];

        $dataJson = json_encode($data);
        $statusDot = $row['status']
            ? "<span class='inline-block w-2 h-2 rounded-full bg-green-500 mr-1'></span>"
            : "<span class='inline-block w-2 h-2 rounded-full bg-red-400 mr-1'></span>";
        $userHtml .= "
            <div class='bg-white border border-amber-100 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden'>
                <div class='bg-red-900 px-4 py-3'>
                    <h3 class='text-white font-bold text-sm truncate'>" . htmlspecialchars($row['email']) . "</h3>
                </div>
                <div class='p-4 flex items-center justify-between gap-2'>
                    <div class='flex items-center gap-1 text-xs font-semibold text-gray-600'>
                        $statusDot $staus
                    </div>
                    <button onclick='EditUser($dataJson)' class='bg-amber-500 hover:bg-amber-400 text-white text-xs font-semibold px-4 py-2 rounded-lg transition'>Edit</button>
                </div>
            </div>";
    }
}


mysqli_close($db);

// Return the results and pagination links as JSON
echo json_encode([
    'html' => $html,
    'userHtml' => $userHtml
]);
