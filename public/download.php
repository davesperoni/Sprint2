<?php

    $server = "127.0.0.1";
    $username = "homestead";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    echo "<p>Resumes:</p><br>";

    $query = "SELECT UploadID, name FROM Upload WHERE Specification = 'Resume'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['UploadID'])){
        $UploadID    = $_GET['UploadID'];
        $query = "SELECT name, type, size, content FROM Upload WHERE UploadID= '$UploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

    echo "<p>Vaccines:</p><br>";
    $query = "SELECT UploadID, name FROM Upload WHERE Specification = 'Vaccine'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['UploadID'])){
        $UploadID    = $_GET['UploadID'];
        $query = "SELECT name, type, size, content FROM Upload WHERE UploadID= '$UploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

    echo "<p>Permits:</p><br>";
    $query = "SELECT UploadID, name FROM Upload WHERE Specification = 'Permit'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($UploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?UploadID=$UploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['UploadID'])){
        $UploadID    = $_GET['UploadID'];
        $query = "SELECT name, type, size, content FROM Upload WHERE UploadID= '$UploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

?>