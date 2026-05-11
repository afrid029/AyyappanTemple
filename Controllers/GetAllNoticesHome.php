<?php
include('DbConnectivity.php');

$query = "SELECT * FROM notices ORDER BY date DESC LIMIT 10";
$result = mysqli_query($db, $query);

$html = "<div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 px-4'>";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "
        <div class='bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col'>
            <img src='" . htmlspecialchars($row['tamnotice']) . "' alt='Tamil Notice'
                onclick=\"openImagePopup('" . htmlspecialchars($row['tamnotice']) . "')\"
                class='w-full object-cover cursor-pointer hover:opacity-90 transition' style='aspect-ratio:3/4;' />
            <div class='p-3 flex flex-col gap-1'>
                <p class='font-bold text-red-900 text-sm leading-tight'>" . htmlspecialchars($row['title']) . "</p>
                <p class='text-xs text-gray-400'>" . htmlspecialchars($row['date']) . "</p>
                <button onclick=\"openImagePopup('" . htmlspecialchars($row['engnotice']) . "')\"
                    class='text-xs text-amber-600 font-semibold hover:underline mt-1 text-left'>View English &rarr;</button>
            </div>
        </div>";
    }
} else {
    $html .= "<div class='col-span-5 text-center text-amber-900 font-semibold py-6'>No Notices Found.</div>";
}

$html .= "</div>";

mysqli_close($db);

echo json_encode(['html' => $html]);
