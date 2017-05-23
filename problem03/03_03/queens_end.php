<?php
$start = microtime(true);

define('BOARD_SIZE', 8);
for ($row = 0; $row < BOARD_SIZE; $row++) {
    $layout[$row] = 1 << $row;
    //echo showBinary($layout[$row]);
}
function showBinary($val) {
    return str_pad(decbin($val), 8, '0', STR_PAD_LEFT) . '<br>';
}

// Find all permutations of an array
function pc_next_permutation($p, $size) {

    // Slide down the array looking for a value smaller than the previous one
    for ($i = $size - 1;@ $p[$i] >= $p[$i+1]; --$i) {}

    // If this doesn't occur, the array has been reversed,
    // and we've finished our permutations
    if ($i == -1) {
        return false;
    }

    // Slide down the array looking for a bigger number than before
    for ($j = $size; $p[$j] <= $p[$i]; --$j) {}

    // Swap them
    $tmp = $p[$i];
    $p[$i] = $p[$j];
    $p[$j] = $tmp;

    // Now reverse the elements in between by swapping the ends
    for (++$i, $j = $size; $i < $j; ++$i, --$j) {
        $tmp = $p[$i];
        $p[$i] = $p[$j];
        $p[$j] = $tmp;
    }
    return $p;
}

$size = BOARD_SIZE - 1;
$perms = 0;
do {
    $perms++;
} while ($layout = pc_next_permutation($layout, $size));

echo "Total permutations: $perms<br>";

$end = microtime(true);
echo 'Time taken: ' . ($end - $start) . ' seconds';