<?php

$owoce = ["jabłko", "banan", "pomarańcza", "gruszka", "winogorono"];

foreach ($owoce as $owoc) {
    $rev = "";

    $length = strlen($owoc);
    for ($i=$length -1; $i > -1; $i--) { 
        $rev .= $owoc[$i];
    }

    echo $rev . (($owoc[0] === "P" || $owoc[0] === "p"  )? " zaczyna się na P " : " nie zaczyna się na P") . "<br>" ;
}

?>
