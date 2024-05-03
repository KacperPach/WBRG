<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie Katalogami</title>
</head>

<body>

    <h2>Zarządzanie Katalogami</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="sciezka">Ścieżka:</label>
        <input type="text" id="sciezka" name="sciezka" required>
        <label for="katalog">Nazwa katalogu:</label>
        <input type="text" id="katalog" name="katalog" required>
        <label for="operacja">Operacja:</label>
        <select id="operacja" name="operacja">
            <option value="read" selected>Odczyt</option>
            <option value="delete">Usuwanie</option>
            <option value="create">Tworzenie</option>
        </select>
        <button type="submit" name="submit">Wykonaj</button>
    </form>

    <?php

    // Funkcja do obsługi operacji na katalogach
    function zarzadzaj_katalogami($sciezka, $katalog, $operacja = 'read')
    {
        // Sprawdzenie czy ścieżka kończy się znakiem '/'
        if (substr($sciezka, -1) !== '/') {
            $sciezka .= '/';
        }

        // Sprawdzenie czy katalog istnieje
        if (!is_dir($sciezka)) {
            return "Błąd: Podana ścieżka nie istnieje.";
        }

        switch ($operacja) {
            case 'delete':
                $sciezka_katalogu = $sciezka . $katalog;
                // Sprawdzenie czy katalog istnieje
                if (!is_dir($sciezka_katalogu)) {
                    return "Błąd: Podany katalog nie istnieje.";
                }
                // Sprawdzenie czy katalog jest pusty
                if (count(scandir($sciezka_katalogu)) > 2) {
                    return "Błąd: Katalog nie jest pusty.";
                }
                // Usunięcie katalogu
                if (rmdir($sciezka_katalogu)) {
                    return "Katalog '$katalog' został usunięty.";
                } else {
                    return "Błąd: Nie udało się usunąć katalogu '$katalog'.";
                }
                break;
            case 'create':
                // Sprawdzenie czy katalog już istnieje
                if (is_dir($sciezka . $katalog)) {
                    return "Błąd: Katalog '$katalog' już istnieje.";
                }
                // Stworzenie katalogu
                if (mkdir($sciezka . $katalog)) {
                    return "Katalog '$katalog' został utworzony.";
                } else {
                    return "Błąd: Nie udało się utworzyć katalogu '$katalog'.";
                }
                break;
            case 'read':
            default:
                if (is_dir($sciezka . $katalog)) {
                    // Odczytanie wszystkich elementów w katalogu
                    $elementy = scandir($sciezka.$katalog);
                    // Usunięcie katalogów '.' i '..'
                    $elementy = array_diff($elementy, array('.', '..'));
                    return implode("; ", $elementy); 
                } else {
                    return "Błąd: Ścierzka nie istnieje";
                }
        }
    }

    // Obsługa formularza
    if (isset($_POST['submit'])) {
        $sciezka = isset($_POST['sciezka']) ? $_POST['sciezka'] : '';
        $katalog = isset($_POST['katalog']) ? $_POST['katalog'] : '';
        $operacja = isset($_POST['operacja']) ? $_POST['operacja'] : 'read';

        $komunikat = zarzadzaj_katalogami($sciezka, $katalog, $operacja);
        echo "<p>$komunikat</p>";
    }

    ?>

</body>

</html>
