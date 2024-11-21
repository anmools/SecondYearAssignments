<?php
    $text = "I love PHP";
    $name = "Anmool"; 

    echo "My name is $name, I have to say that $text.<br>";

    echo "The text '$text' has " . strlen($text) . " characters.<br>";
    
    $phpPosition = strpos($text, "PHP");
    echo "The word 'PHP' is located at position $phpPosition in the text.";
?>
