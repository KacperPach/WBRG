<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZADANIE 1</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" name="liczba1" id="">
        <input type="number" name="liczba2" id="">
        <select name="dzialanie" id="">
            <option value="*">mnożenie</option>
            <option value="/">dzielenie</option>
            <option value="-">odejmowanie</option>
            <option value="+">dodawanie</option>
        </select>
        <button type="submit">submit</button>
    </form>
    <?php 
    if (isset($_POST['liczba1'],$_POST['liczba2'],$_POST['dzialanie'])) {
        $l1 = $_POST['liczba1'];
        $l2 = $_POST['liczba2'];
        $op = $_POST['dzialanie'];

        $res = 0;
        switch ($op) {
            case '+':
                $res = $l1 + $l2; 
                break;
            case '-':
                $res = $l1 - $l2; 
                break;
            case '*':
                $res = $l1 * $l2; 
                break;
            case '/':
                $res = $l1 / $l2; 
                break;
        }
        echo "wynik: ".$res;
    }
    ?>
    
</body>
</html>