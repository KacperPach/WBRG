<?php 

function createAssociativeArray($items) {
    $associativeArray = [];
    foreach ($items as $i => $value) {
        if ($i % 2 == 0) {
            $nextValue = isset($items[$i + 1]) ? $items[$i + 1] : null;
            $associativeArray[$value] = $nextValue;
        }
    }
    return $associativeArray;
}

$znakiInterpunkcyjne = ['.', ',', ';', ':', '!', '?', '"'];
$words = explode(' ', "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum." );
$offset = 0;
for ($i=0; $i < count($words); $i++) { 
    foreach($znakiInterpunkcyjne as $znak) {
        if (str_contains($words[$i], $znak)) {
            for ($j=$i; $j < count($words); $j++) { 
                $words[$j] = empty($words[$j+1])? "": $words[$j+1];
            }
            break;
        }  
    }
}
foreach($words as $w) {
    echo $w." ";
}

$AssociativeArray = createAssociativeArray($words);
foreach ($AssociativeArray as $key => $value) {
     echo "$key -- $value <br>";
}
?>
