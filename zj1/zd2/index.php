<?php 
    function isPrime($num) {
        if ($num <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }
        return true;
    }
    
    $start = $_GET['start'];
    $end = $_GET['end'];

    for ($num = $start; $num <= $end; $num++) {
        if (isPrime($num)) {
            echo $num . " ";
        }
    }
?>
