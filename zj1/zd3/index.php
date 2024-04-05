<?php 

function fibonacci($n) {
    $fib = [0, 1]; 

    for ($i = 2; $i <= $n; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2]; 
    }

    return $fib;
}

$n = $_GET["n"]; 

$fibonacciSeq = fibonacci($n);

$lineNumber = 1;

foreach ($fibonacciSeq as $number) {
    if ($number % 2 !== 0) { 
        echo $lineNumber . ": " . $number . "<br>";
        $lineNumber++;
    }
}

?>
