<?php
include('DbConnectivity.php');


$query="SELECT *
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

         $html .= "<div class='event'>
                    <div class='eventHead'>
                        <h4>".$date." | ".$name."</h4>
                        <small>".$time."</small>
                    </div>
                    <hr>
                    <div class='eventDesc'>
                       ".$desc."
                    </div>
                </div>";
    }
} else {
    $html .= "<div style='display: grid;justify-self: flex-start;width: 100%'>
    <div class='no-event'>No Upcoming Events Found.</div>
    </div>";
}


mysqli_close($db);

// Return the results and pagination links as JSON
echo json_encode([
    'html' => $html
]);


