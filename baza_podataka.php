<?php
    function OpenCon()
     {
     $dbhost = "localhost";
     $dbuser = "root";
     $dbpass = "";
     $db = "upravljanje";
     $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db) or die("Konekcija neuspesna: %s\n". $conn -> error);
     
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }

     function set_url( $url )
    {
        echo("<script>history.replaceState({},'','$url');</script>");
    }  

    ?>