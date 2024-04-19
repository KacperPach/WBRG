<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprawdź czy liczba jest liczbą pierwszą</title>
</head>
<body>
    <h2>Sprawdź czy liczba jest liczbą pierwszą</h2>
    <form method="post">
        <label for="number">Wprowadź liczbę całkowitą dodatnią:</label><br>
        <input type="text" id="number" name="number" required><br><br>
        <button type="submit">Sprawdź</button>
    </form>

    <?php
    // Funkcja sprawdzająca, czy liczba jest liczbą pierwszą
    function is_prime($number, &$iterations) {
        $iterations = 0;
        if ($number <= 1) {
            return false;
        }
        for ($i = 2; $i * $i <= $number; $i++) {
            $iterations++;
            if ($number % $i == 0) {
                return false;
            }
        }
        return true;
    }

    // Sprawdzenie, czy formularz został wysłany
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sprawdzenie, czy wprowadzona wartość jest liczbą całkowitą dodatnią
        if (isset($_POST['number']) && is_numeric($_POST['number']) && $_POST['number'] > 0 && floor($_POST['number']) == $_POST['number']) {
            $number = (int)$_POST['number'];

            // Zmienna do zliczania iteracji pętli
            $iterations = 0;

            // Sprawdzenie, czy liczba jest liczbą pierwszą
            $is_prime = is_prime($number, $iterations);

            // Wyświetlenie wyniku
            if ($is_prime) {
                echo "<p>Liczba $number jest liczbą pierwszą.</p>";
            } else {
                echo "<p>Liczba $number nie jest liczbą pierwszą.</p>";
            }
            echo "<p>Liczba iteracji potrzebnych do sprawdzenia: $iterations</p>";
        } else {
            echo "<p>Podano niepoprawną liczbę. Proszę wprowadzić liczbę całkowitą dodatnią.</p>";
        }
    }
    ?>
</body>
</html>
