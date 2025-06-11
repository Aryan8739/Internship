<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php tut </title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container{
        max-width: 80%;
        background-color: grey;
        margin: auto;
        padding: 20px;
    }
</style>
<body>
<div class="container">
    <h1>Lets Learn about php</h1>
    This is a container...
    <?php
        $age = 20;
    if ($age>18){
        echo "You can go to party";
    
    }
    else {
        echo "You can not go to party";
    }

echo "<br>";
    $lang = array("py","c++","php","node js");  // Array
    // echo $lang[0];
    // echo count($lang);

    // Loops in php
$a = 0;
    while ($a <= 5) {
           
        echo "The Value of a is ";
        echo $a++;
        echo "<br>";
    }
  // For each
  foreach($lang as $value){     //Use of as values
    echo "The value is :";
    echo $value , "<br>";       // Use of ","
  } 

//   function 
function print5(){
    echo "five";

}
print5()

    ?>
</div>
    
</body>
</html>
