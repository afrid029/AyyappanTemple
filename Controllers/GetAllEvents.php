<?php
include('DbConnectivity.php');

$query="SELECT *
from events Where date >= CURRENT_DATE
ORDER BY date asc, time asc";

$result = mysqli_query($db, $query);
// echo $result;

$html = '';


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "


                     <div class='event-card'>
                <div class='event-title'>
                   ".$row['title']."
                </div>
                <hr>
                <div class='event-info'>
                   <div class='event-action'>
                        <p>". $row['date'] ."</p>
                        <p>". $row['time'] ."</p>
                   </div>
                    <div class='event-btn'>
                        <button onclick='EditEvent(".json_encode($row).")' class='edit'>Edit</button>
                        <button onclick='DeleteEvent(".json_encode($row).")' class='delete'>Delete</button>
                    </div>
                </div>
            </div>";
    }
} else {
    $html .= "<div style='display: grid;justify-self: flex-start;width: 100%'>
    <div style='grid-column: span 5; text-align: left; font-size: 12px; font-weight:700;'>No Upcoming Events Found.</div>
    </div>";
}

$userHtml = "";

if($_SESSION['role'] === 'superadmin'){ 
$query = "SELECT * FROM users where role='Admin'";
$result1 = mysqli_query($db, $query);



 while($row = mysqli_fetch_assoc($result1)){
            $class = $row['status'] ? 'active-status' : 'deactive-status';
            $staus = $row['status'] ? 'Active' : 'Disabled';
            $data = [
                'ID' => $row['ID'],
                'email' => $row['email'],
                'role' => $row['role'],
                'password' => $row['password'],
                'status' => $row['status']
            ];

            $data = json_encode($data);
            $userHtml .= "<div class='program'>
            <h3>". $row['email'] ."</h3>
            <div class='program-bar'>
                <div class='next-slot user-status'>
                     <div class = '". $class ."'></div>
                    <div>Status : ". $staus ."</div>

                </div>

                <div class='modify'>
                    <div  onclick=EditUser(". $data .") class='edit'>
                        Edit
                    </div>
                </div>
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