<?php
$length=6;
$width=7;
$area = $length * $width;
$perimeter=2*($length+$width);
echo "Area: " . $area . "<br>";
echo "Perimeter: " . $perimeter . "<br>";
?>



<?php
$amount=5000;
$vat=15/100*$amount;
echo "VAT: " . $vat . "<br>";
?>



<?php
$number=7;
if ($number%2== 0) {
    echo $number . " is Even" . "<br>";
} else {
    echo $number . " is Odd" . "<br>";
}
?>



<?php
$a=15;
$b=42;
$c=27;
if ($a>=$b && $a>=$c) {
    echo "Largest: " . $a . "<br>";
} elseif ($b>=$a && $b>=$c) {
    echo "Largest: " . $b . "<br>";
} else {
    echo "Largest: " . $c . "<br>";
}
?>



<?php
for ($i=10; $i<=100; $i++) {
    if ($i% 2!=0) {
        echo $i . " " . "<br>";
    }
}
?>


<?php
$arr = [45, 22, 18, 23, 47, 37];
$search = 23;
$found = false;
for ($i = 0; $i < count($arr); $i++) {
    if ($arr[$i] == $search) {
        $found = true;
        break;
    }
}
if ($found) {
    echo $search . " found in the array." . "<br>";
} else {
    echo $search . " not found in the array." . "<br>";
}
?>



<?php
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "* ";
    }
    echo "<br>";
}

echo "<br>";

for ($i = 3; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        echo $j . " ";
    }
    echo "<br>";
}

echo "<br>";

$letter = 65;
for ($i = 1; $i <= 3; $i++) {
    for ($j = 0; $j < $i; $j++) {
        echo chr($letter++) . " ";
    }
    echo "<br>";
}
?>