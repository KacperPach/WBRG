<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silnia i Fibonacci</title>
</head>

<body>

    <h2>Obliczanie Silni i Ciągu Fibonacciego</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label for="argument">Podaj argument:</label>
        <input type="number" id="argument" name="argument" required>
        <button type="submit" name="submit_silnia">Oblicz Silnię</button>
        <button type="submit" name="submit_fibonacci">Oblicz Ciąg Fibonacciego</button>
    </form>

    <?php

    // Funkcja rekurencyjna obliczająca silnię
    function silnia_rekurencyjna($n)
    {
        if ($n == 0 || $n == 1) {
            return 1;
        } else {
            return $n * silnia_rekurencyjna($n - 1);
        }
    }

    // Funkcja nierekurencyjna obliczająca silnię
    function silnia_nierekurencyjna($n)
    {
        $silnia = 1;
        for ($i = 1; $i <= $n; $i++) {
            $silnia *= $i;
        }
        return $silnia;
    }

    // Funkcja rekurencyjna obliczająca wyraz ciągu Fibonacciego
    function fibonacci_rekurencyjny($n)
    {
        if ($n == 0) {
            return 0;
        } elseif ($n == 1 || $n == 2) {
            return 1;
        } else {
            return fibonacci_rekurencyjny($n - 1) + fibonacci_rekurencyjny($n - 2);
        }
    }

    // Funkcja nierekurencyjna obliczająca wyraz ciągu Fibonacciego
    function fibonacci_nierekurencyjny($n)
    {
        $fibonacci = [0, 1];
        for ($i = 2; $i <= $n; $i++) {
            $fibonacci[$i] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
        }
        return $fibonacci[$n];
    }

    // Funkcja do pomiaru czasu wykonania funkcji
    function zmierz_czas($funkcja, $argument)
    {
        $start = microtime(true);
        $wynik = $funkcja($argument);
        $koniec = microtime(true);
        return $koniec - $start;
    }

    if (isset($_GET['submit_silnia']) && isset($_GET['argument'])) {
        $argument = intval($_GET['argument']);

        // Pomiar czasu dla funkcji rekurencyjnej
        $czas_rekurencyjna = zmierz_czas('silnia_rekurencyjna', $argument);

        // Pomiar czasu dla funkcji nierekurencyjnej
        $czas_nierekurencyjna = zmierz_czas('silnia_nierekurencyjna', $argument);

        // Wyświetlenie wyników dla silni
        echo "<h3>Silnia dla $argument:</h3>";
        echo "Czas rekurencyjnej: $czas_rekurencyjna sekund<br>";
        echo "Czas nierekurencyjnej: $czas_nierekurencyjna sekund<br>";

        // Wyświetlenie samej silni dla podanego argumentu
        $silnia = silnia_nierekurencyjna($argument);
        echo "Silnia: $silnia<br>";
    }

    if (isset($_GET['submit_fibonacci']) && isset($_GET['argument'])) {
        $argument = intval($_GET['argument']);

        // Pomiar czasu dla funkcji rekurencyjnej
        $czas_rekurencyjna = zmierz_czas('fibonacci_rekurencyjny', $argument);

        // Pomiar czasu dla funkcji nierekurencyjnej
        $czas_nierekurencyjna = zmierz_czas('fibonacci_nierekurencyjny', $argument);

        // Wyświetlenie wyników dla ciągu Fibonacciego
        echo "<h3>Ciąg Fibonacciego dla $argument:</h3>";
        echo "Czas rekurencyjnej: $czas_rekurencyjna sekund<br>";
        echo "Czas nierekurencyjnej: $czas_nierekurencyjna sekund<br>";

        // Wyświetlenie samego ciągu Fibonacciego
        echo "Ciąg Fibonacciego: ";
        for ($i = 0; $i <= $argument; $i++) {
            echo fibonacci_nierekurencyjny($i) . " ";
        }
        echo "<br>";
    }

    ?>

</body>

</html>
