<?php
include('DbConnectivity.php');

$query = "SELECT * FROM notices ORDER BY date DESC";
$result = mysqli_query($db, $query);

$html = '';

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data = json_encode([
            'ID'         => $row['ID'],
            'title'      => $row['title'],
            'date'       => $row['date'],
            'tamnotice'  => $row['tamnotice'],
            'engnotice'  => $row['engnotice']
        ]);

        $html .= "
        <div class='bg-white border border-amber-100 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden'>
            <div class='bg-orange-600 px-4 py-3'>
                <h3 class='text-white font-bold text-sm truncate'>" . htmlspecialchars($row['title']) . "</h3>
            </div>
            <div class='p-4 flex flex-col gap-3'>
                <p class='text-gray-400 text-xs font-semibold'>" . htmlspecialchars($row['date']) . "</p>
                <div class='flex gap-3'>
                    <a href='" . htmlspecialchars($row['tamnotice']) . "' target='_blank' class='text-xs font-semibold text-orange-700 underline hover:text-orange-500'>Tamil Notice</a>
                    <a href='" . htmlspecialchars($row['engnotice']) . "' target='_blank' class='text-xs font-semibold text-orange-700 underline hover:text-orange-500'>English Notice</a>
                </div>
                <div class='flex gap-2'>
                    <button onclick='EditNotice(" . $data . ")' class='flex-1 bg-amber-500 hover:bg-amber-400 text-white text-xs font-semibold py-2 rounded-lg transition'>Edit</button>
                    <button onclick='DeleteNotice(" . $data . ")' class='flex-1 bg-red-700 hover:bg-red-600 text-white text-xs font-semibold py-2 rounded-lg transition'>Delete</button>
                </div>
            </div>
        </div>";
    }
} else {
    $html .= "<div class='col-span-3 text-center text-gray-400 text-sm py-6 font-semibold'>No notices found.</div>";
}

mysqli_close($db);

echo json_encode(['html' => $html]);
