<?php
    $db = mysqli_connect('localhost', 'root','','');
    if(!$db){
        echo mysqli_connect_error($db);
    }

    function clear($data){
        global $db;
        $data=mysqli_real_escape_string($db, htmlspecialchars($data));
        return $data;
    }
?>