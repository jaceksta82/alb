<?php
function test1($input) {
    $result = [];
    while ($input > 0) {
        $maxDigit = min($input, 8);
        $result[] = $maxDigit;
        $input -= $maxDigit;
    }
    rsort($result);
    return $result;
}


print_r(test1(20));
print_r(test1(7));
print_r(test1(9));


/////////////////////////////////////////////////////


function test2($input) {
    if ($input <= 0) {
        return [];
    }
    
    $maxDigit = min($input, 8);
    $result = test2($input - $maxDigit);
    array_unshift($result, $maxDigit);
    return $result;
}


print_r(test2(20));
print_r(test2(7));
print_r(test2(9));


/////////////////////////////////////////////////////


function test3($input) {
    $result = [];
    $maxDigit = 8;
    
    while ($input > 0) {
        if ($input >= $maxDigit) {
            $result[] = $maxDigit;
            $input -= $maxDigit;
        } else {
            $result[] = $input;
            break;
        }
    }
    
    return $result;
}


print_r(test3(20));
print_r(test3(7));
print_r(test3(9));

?>