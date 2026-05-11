<?php
include('DbConnectivity.php');


$query = "SELECT *
from events Where date >= CURRENT_DATE
ORDER BY date asc, time asc
LIMIT 10";

$result = mysqli_query($db, $query);
// echo $result;

$html = '';


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['title'];
        $date = $row['date'];
        $time = $row['time'];
        $desc = $row['description'];

        $html .= "<div class='bg-white bg-opacity-90 rounded-xl p-4 shadow'>
                    <div class='flex justify-between items-center mb-1'>
                        <h4 class='font-bold text-red-900 text-sm leading-snug'>" . $name . "</h4>
                        <span class='text-xs text-amber-600 font-semibold whitespace-nowrap ml-2'>" . $time . "</span>
                    </div>
                    <p class='text-xs text-gray-500 mb-2'>" . $date . "</p>
                    <hr class='border-amber-200 mb-2'>
                    <p class='text-xs text-gray-700 leading-relaxed'>" . $desc . "</p>
                </div>";
    }
} else {
    $html .= "<div class='p-4 text-center text-red-200 text-sm font-semibold'>No Upcoming Events Found.</div>";
}


mysqli_close($db);

// Return the results and pagination links as JSON
echo json_encode([
    'html' => $html
]);
