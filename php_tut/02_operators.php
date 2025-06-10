<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    $var1 = 34;
    $var2 = 35;
    // Operators in php

    // Arithmetic
    echo "The value of var1+var2 is :";
    echo "<br>"; // new line
    echo $var1 + $var2;

    // Assignment
    $newvar =$var1;
    echo "<br>";
    echo "The Value of new var is ";
    echo $newvar;
    $newvar += 1;  // Add 1 to no.
    echo "<br>";
    echo $newvar;

    // Comparison
    echo "The value of 1==4 is: ";
    // var_dump(1==4);          // This gives  C:\wamp64\www\php01\02_operators.php:31:boolean false (if Xdebug)
    var_export(1==4);
    echo "<br>";

    echo "The value of 1<4 is: ";
    var_dump(1<4); 
    echo "<br>";
    
    echo "The value of 1!=4 is: ";
    var_dump(1!=4); 
    echo "<br>";

    echo "The value of 1>4 is: ";
    var_dump(1>4); 

    // Increment/decrement
 echo $var1++;
 echo "<br>";
 echo $var1--;
 echo "<br>";
 echo ++$var1;
 echo "<br>";
 echo --$var2;
 echo "<br>";

    // Logical


    // and (&&)
    // or(||)
    // xor
    // !

    ?>
    
</body>
</html>