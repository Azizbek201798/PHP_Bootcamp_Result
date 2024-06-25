<?php

function sortStructureByDateAndSkippedDays($dates, $arrivedAt, $leavedAt) {

    $structure = [];

    for ($i = 0; $i < count($dates); $i++) {
        $structure[] = array(
            'date' => $dates[$i],
            'arrivedAt' => $arrivedAt[$i],
            'leavedAt' => $leavedAt[$i],
            'skippedDays' => strtotime($dates[$i]) - strtotime($leavedAt[$i-1]) - 86400 
        );
    }

    usort($structure, function ($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });

    usort($structure, function ($a, $b) {
        return $a['skippedDays'] - $b['skippedDays'];
    });

    return $structure;
}

$dates = ['2024-06-23', '2024-06-25', '2024-06-24'];
$arrivedAt = ['10:00', '09:30', '11:00'];
$leavedAt = ['18:00', '17:00', '19:30'];

$result = sortStructureByDateAndSkippedDays($dates, $arrivedAt, $leavedAt);

foreach ($result as $item) {
    echo "Date: " . $item['date'] . ", Arrived At: " . $item['arrivedAt'] . ", Leaved At: " . $item['leavedAt'] . ", Skipped Days: " . $item['skippedDays'] . PHP_EOL;
}

?>