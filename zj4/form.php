<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZADANIE 1</title>
</head>
<body style="display: flex; justify-content: space-evenly; padding-top: 20px">
    <?php
        session_start();

        // Check if the user is logged in, if not redirect to login page
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: index.html');
            exit;
        }

        $res = isset($_GET["reset"])? $_GET["reset"] : false;
        if ( $res == true) {
            setcookie('guests', '', -1, "/");
            setcookie('name', '', -1, "/");
            setcookie('surname', '', -1, "/");
            setcookie('address', '',-1, "/");
            setcookie('credit_card', '', -1, "/");
            setcookie('email', '', -1, "/");
            setcookie('arrival_date', '', -1, "/");
            setcookie('arrival_time', '', -1, "/");
            setcookie('amenities', '', -1, "/");

            header("Location: index.php");
            exit;
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            setcookie('guests', $_POST['guests'], time() + (86400 * 30), "/");
            setcookie('name', $_POST['name'], time() + (86400 * 30), "/");
            setcookie('surname', $_POST['surname'], time() + (86400 * 30), "/");
            setcookie('address', $_POST['address'], time() + (86400 * 30), "/");
            setcookie('credit_card', $_POST['credit_card'], time() + (86400 * 30), "/");
            setcookie('email', $_POST['email'], time() + (86400 * 30), "/");
            setcookie('arrival_date', $_POST['arrival_date'], time() + (86400 * 30), "/");
            setcookie('arrival_time', $_POST['arrival_time'], time() + (86400 * 30), "/");
            if(isset($_POST['amenities']))
                setcookie('amenities', json_encode($_POST['amenities']), time() + (86400 * 30), "/");
        }
    ?>

    <form action="" method="post">
        <label for="guests">Ilość osób:</label>
        <select id="guests" name="guests" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <br><br>
        <label for="name">Imię:</label>
        <input type="text" id="name" name="name" value="<?php getCookieValue("name")?>" required><br><br>
        <label for="surname">Nazwisko:</label>
        <input type="text" id="surname" name="surname"  value="<?php getCookieValue("surname")?>" required><br><br>
        <label for="address">Adres:</label>
        <input type="text" id="address" name="address"  value="<?php getCookieValue("address")?>" required><br><br>
        <label for="credit_card">Dane karty kredytowej:</label>
        <input type="text" id="credit_card" name="credit_card" value="<?php getCookieValue("credit_card")?>" required><br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php getCookieValue("email")?>" required><br><br>
        <label for="arrival_date">Data przyjazdu:</label>
        <input type="date" id="arrival_date" name="arrival_date"  value="<?php getCookieValue("arrival_date")?>" required><br><br>
        <label for="arrival_time">Godzina przyjazdu:</label>
        <input type="time" id="arrival_time" name="arrival_time" value="<?php getCookieValue("arrival_time")?>" required><br><br>
        <label>Udogodnienia:</label><br>
        <input type="checkbox" id="ac" name="amenities[]" value="klimatyzacja" <?php getAmenitieschecked("klimatyzacja")?>>
        <label for="ac">Klimatyzacja</label><br>
        <input type="checkbox" id="ashtray" name="amenities[]" value="popielniczka"<?php getAmenitieschecked("popielniczka")?>>
        <label for="ashtray">Popielniczka dla palacza</label><br>
        <input type="checkbox" id="child_bed" name="amenities[]" value="dostawienie_lozka_dla_dziecka"<?php getAmenitieschecked("dostawienie_lozka_dla_dziecka")?>>
        <label for="child_bed">Dostawienie łóżka dla dziecka</label><br><br>
        <input type="submit" value="Zarezerwuj">
        <input type="button" onclick='location.href="index.php?reset=true"' value="reset">
    </form>

    <div>
    <?php
        $errors = []; // Tablica przechowująca ewentualne błędy

        // Sprawdzamy, czy formularz został wysłany
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Pobieramy dane z formularza
            $guests = isset($_POST['guests']) ? $_POST['guests'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $credit_card = isset($_POST['credit_card']) ? $_POST['credit_card'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $arrival_date = isset($_POST['arrival_date']) ? $_POST['arrival_date'] : '';
            $arrival_time = isset($_POST['arrival_time']) ? $_POST['arrival_time'] : '';
            $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : array();
            $child_bed = isset($_POST['child_bed']) ? "Tak" : "Nie";

            // Walidacja pól
            if (!isset($guests) || $guests == '') {
                $errors[] = "Proszę wybrać ilość osób.";
            }
            if (!isset($name) || $name == '') {
                $errors[] = "Proszę podać imię.";
            }
            if (!isset($surname) || $surname == '') {
                $errors[] = "Proszę podać nazwisko.";
            }
            if (!isset($address) || $address == '') {
                $errors[] = "Proszę podać adres.";
            }
            if (!isset($credit_card) || $credit_card == '') {
                $errors[] = "Proszę podać dane karty kredytowej.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Proszę podać poprawny adres e-mail.";
            }
            if (!isset($arrival_date) || $arrival_date == '') {
                $errors[] = "Proszę podać datę przyjazdu.";
            }
            if (!isset($arrival_time) || $arrival_time == '') {
                $errors[] = "Proszę podać godzinę przyjazdu.";
            }

            // Wyświetlanie błędów, jeśli istnieją
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            } else {
                // Tworzymy szablon HTML dla podsumowania rezerwacji
                $summary = "
                    <h2>Podsumowanie rezerwacji</h2>
                    <p><strong>Ilość osób:</strong> $guests</p>
                    <p><strong>Imię:</strong> $name</p>
                    <p><strong>Nazwisko:</strong> $surname</p>
                    <p><strong>Adres:</strong> $address</p>
                    <p><strong>Dane karty kredytowej:</strong> $credit_card</p>
                    <p><strong>E-mail:</strong> $email</p>
                    <p><strong>Data przyjazdu:</strong> $arrival_date</p>
                    <p><strong>Godzina przyjazdu:</strong> $arrival_time</p>
                    <p><strong>Udogodnienia:</strong> ";
                
                // Dodajemy udogodnienia do podsumowania
                if (!empty($amenities)) {
                    $summary .= "<ul>";
                    foreach ($amenities as $amenity) {
                        $summary .= "<li>$amenity</li>";
                    }
                    $summary .= "</ul>";
                } else {
                    $summary .= "Brak wybranych udogodnień";
                }

                // Dodajemy informację o dostawieniu łóżka dla dziecka
                $summary .= "<p><strong>Dostawienie łóżka dla dziecka:</strong> $child_bed</p>";

                // Wyświetlamy podsumowanie rezerwacji
                echo $summary;
                
            }
        } else {
            // Jeśli formularz nie został wysłany, wyświetlamy komunikat
            echo "Formularz nie został przesłany.";
        }

        function getCookieValue($name) {
            echo isset($_COOKIE[$name]) ? $_COOKIE[$name] :"";
        }

        function getAmenitieschecked($name) {
            $amenities = isset($_COOKIE['amenities']) ? json_decode($_COOKIE['amenities']) : array();
            if(isset($amenities)) {
                echo in_array( $name, $amenities)? "checked": "";
            }
           
        }
    ?>
    </div>
    
</body>
</html>