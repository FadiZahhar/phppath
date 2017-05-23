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

function checkDiagonals($layout) {
    $row = 0;
    while ($row < BOARD_SIZE) {
        // Initialize offset for row and column numbers
        $offset = 1;
        // Use the offset to check each row in turn against the current row
        while ($offset < BOARD_SIZE - $row) {
            // Check for diagonal attacks from left and right
            $ld = $layout[$row + $offset] << $offset;
            $rd = $layout[$row + $offset] >> $offset;
            // If the shifted value is the same as the row being checked,
            // the queen can be attacked diagonally, so return false
            if ($layout[$row] == $ld || $layout[$row] == $rd) {
                return false;
            }
            $offset++;
        }
        $row++;
    }
    // If no attacks have been detected, return true
    return true;
}

$size = BOARD_SIZE - 1;
$solutions = array();
do {
    if (checkDiagonals($layout)) {
        $solutions[] = $layout;
    }
} while ($layout = pc_next_permutation($layout, $size));

echo "Total solutions: " . count($solutions) . "<br>";

$end = microtime(true);
echo 'Time taken: ' . ($end - $start) . ' seconds';