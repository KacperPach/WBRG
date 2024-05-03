<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz daty urodzenia</title>
</head>
<body>

<?php
if(isset($_GET['data_urodzenia'])) {
    $data_urodzenia = $_GET['data_urodzenia'];

    // Funkcja do sprawdzenia w jakim dniu tygodnia użytkownik się urodził
    function dzien_tygodnia($data) {
        $dzien_tygodnia = date('l', strtotime($data));
        return $dzien_tygodnia;
    }

    // Funkcja do obliczenia wieku użytkownika
    function wiek($data) {
        $dzisiaj = new DateTime('today');
        $urodziny = new DateTime($data);
        $wiek = $urodziny->diff($dzisiaj)->y;
        return $wiek;
    }

    // Funkcja do obliczenia ilości dni do najbliższych przyszłych urodzin
    function dni_do_urodzin($data) {
        $aktualny_rok = date('Y');
        $urodziny_w_tym_roku = date('Y') . date('-m-d', strtotime($data));
        $urodziny_w_tym_roku = new DateTime($urodziny_w_tym_roku);
        if ($urodziny_w_tym_roku < new DateTime()) {
            $urodziny_w_tym_roku->modify('+1 year');
        }
        $dni_do_urodzin = $urodziny_w_tym_roku->diff(new DateTime())->days;
        return $dni_do_urodzin;
    }

    // Wyświetlanie wyników
    echo "Urodziłeś/aś się w dniu: " . dzien_tygodnia($data_urodzenia) . "<br>";
    echo "Masz " . wiek($data_urodzenia) . " lat<br>";
    echo "Do najbliższych urodzin pozostało " . dni_do_urodzin($data_urodzenia) . " dni<br>";
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <label for="data_urodzenia">Wybierz datę urodzenia:</label>
    <input type="date" id="data_urodzenia" name="data_urodzenia">
    <button type="submit">Wyślij</button>
</form>

</body>
</html>
