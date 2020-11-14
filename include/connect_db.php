<?php
// Connnect database
$conn = mysqli_connect("localhost","root","","shop");
// Timezone default set
date_default_timezone_set("Asia/Bangkok");
// Character set
mysqli_set_charset($conn,"utf8");

    if(mysqli_connect_errno()){
        
        // echo date_default_timezone_get();
        // echo "</br>";
        // echo mysqli_character_set_name($conn);
        echo "</br> Can't connection your database becuz : ";
        echo mysqli_connect_error();
        exit;
        
    }
    // echo date_default_timezone_get();
    // echo "</br>";
    // echo mysqli_character_set_name($conn);
?>