<?php
// Ustawienia połączenia z bazą danych
$servername = "localhost";
$username = "root"; // domyślny użytkownik XAMPP
$password = "";
$dbname = "test_db";

// Nawiązanie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

// INSERT INTO
$sql = "INSERT INTO users (name, email) VALUES ('kacper pach', 'kacper@pach.com')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// SELECT i mysqli_fetch_row
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Using mysqli_fetch_row:<br>";
    while($row = $result->fetch_row()) {
        echo "id: " . $row[0] . " - Name: " . $row[1] . " - Email: " . $row[2] . "<br>";
    }
} else {
    echo "0 results";
}

// SELECT i mysqli_fetch_array
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Using mysqli_fetch_array:<br>";
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "id: " . $row['id'] . " - Name: " . $row['name'] . " - Email: " . $row['email'] . "<br>";
    }
} else {
    echo "0 results";
}

// mysqli_num_rows
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

echo "Number of rows: " . $result->num_rows . "<br>";

// Zamknięcie połączenia
$conn->close();
?>
