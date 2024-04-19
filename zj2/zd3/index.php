<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZADANIE 1</title>
</head>

<body style="display: flex; justify-content: space-evenly; padding-top: 20px">

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
        <input type="text" id="name" name="name" required><br><br>
        <label for="surname_1">Nazwisko:</label>
        <input type="text" id="surname" name="surname" required><br><br>
        <label for="address">Adres:</label>
        <input type="text" id="address" name="address" required><br><br>
        <label for="credit_card">Dane karty kredytowej:</label>
        <input type="text" id="credit_card" name="credit_card" required><br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="arrival_date">Data przyjazdu:</label>
        <input type="date" id="arrival_date" name="arrival_date" required><br><br>
        <label for="arrival_time">Godzina przyjazdu:</label>
        <input type="time" id="arrival_time" name="arrival_time" required><br><br>
        <label>Udogodnienia:</label><br>
        <input type="checkbox" id="ac" name="amenities[]" value="klimatyzacja">
        <label for="ac">Klimatyzacja</label><br>
        <input type="checkbox" id="ashtray" name="amenities[]" value="popielniczka">
        <label for="ashtray">Popielniczka dla palacza</label><br>
        <input type="checkbox" id="child_bed" name="amenities[]" value="dostawienie lozka dla dziecka">
        <label for="child_bed">Dostawienie łóżka dla dziecka</label><br><br>
        <?php
        $guests = isset($_POST['guests']) ? $_POST['guests'] : 0;
        if ($guests > 1) {
            for ($i = 2; $i < $guests + 1; $i++) {
                echo "
                   <p>Dane osoby $i</p>
                   <label for='name_$i'>Imię $i:</label>
                   <input type='text' id='name_$i' name='name_$i' ><br><br>
                   <label for='surname_$i'>Nazwisko $i:</label>
                   <input type='text' id='surname_$i' name='surname_$i' ><br><br>
                   <label for='email_$i'>E-mail $i:</label>
                   <input type='email' id='email_$i' name='email_$i' ><br><br>";
            }
        }
        ?>
        <input type="submit" value="Zarezerwuj">
    </form>

    <div>
        <?php
        $errors = []; // Tablica przechowująca ewentualne błędy
        
        // Sprawdzamy, czy formularz został wysłany
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Funkcja pomocnicza do sprawdzania, czy pole jest puste
            function is_empty($value)
            {
                return $value === '';
            }

            // Funkcja pomocnicza do sprawdzania poprawności adresu e-mail
            function is_valid_email($email)
            {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            }

            // Pobieramy dane z formularza
            $guests = isset($_POST['guests']) ? $_POST['guests'] : 0;

            // Sprawdzamy, czy wybrano ilość osób
            if ($guests < 1) {
                $errors[] = "Proszę wybrać ilość osób.";
            }

            // Pobieramy dane pierwszej osoby
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $credit_card = isset($_POST['credit_card']) ? $_POST['credit_card'] : '';
            $arrival_date = isset($_POST['arrival_date']) ? $_POST['arrival_date'] : '';
            $arrival_time = isset($_POST['arrival_time']) ? $_POST['arrival_time'] : '';
            $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : array();

            // Walidacja pól dla pierwszej osoby
            if (is_empty($name)) {
                $errors[] = "Proszę podać imię.";
            }
            if (is_empty($surname)) {
                $errors[] = "Proszę podać nazwisko.";
            }
            if (is_empty($address)) {
                $errors[] = "Proszę podać adres.";
            }
            if (is_empty($credit_card)) {
                $errors[] = "Proszę podać numer karty kredytowej.";
            }
            if (is_empty($arrival_date)) {
                $errors[] = "Proszę podać datę przyjazdu.";
            }
            if (is_empty($arrival_time)) {
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
            <h3>Dane osoby 1</h3>
            <p><strong>Imię:</strong> $name</p>
            <p><strong>Nazwisko:</strong> $surname</p>
            <p><strong>Adres:</strong> $address</p>
            <p><strong>Numer karty kredytowej:</strong> $credit_card</p>
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

                // Dodajemy dane dla kolejnych osób do podsumowania
                for ($i = 2; $i <= $guests; $i++) {
                    $name = isset($_POST["name_$i"]) ? $_POST["name_$i"] : '';
                    $surname = isset($_POST["surname_$i"]) ? $_POST["surname_$i"] : '';
                    $email = isset($_POST["email_$i"]) ? $_POST["email_$i"] : '';

                    $summary .= "
                <h3>Dane osoby $i</h3>
                <p><strong>Imię:</strong> $name</p>
                <p><strong>Nazwisko:</strong> $surname</p>
                <p><strong>E-mail:</strong> $email</p>";
                }

                // Wyświetlamy podsumowanie rezerwacji
                echo $summary;
            }
        } else {
            // Jeśli formularz nie został wysłany, wyświetlamy komunikat
            echo "Formularz nie został przesłany.";
        }
        ?>
    </div>

</body>

</html>