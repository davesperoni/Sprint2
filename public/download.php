<?php

    $server = "localhost";
    $username = "root";
    $password = "secret";
    $database = "wildlifeDB";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed!\n" . $conn->connect_error);
    } else {
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    echo "<p>Resumes:</p><br>";

    $query = "SELECT resumeUploadID, name FROM resumeUpload";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($resumeUploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?resumeUploadID=$resumeUploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['resumeUploadID'])){
        $resumeUploadID    = $_GET['resumeUploadID'];
        $query = "SELECT name, type, size, content FROM resumeUpload WHERE resumeUploadID= '$resumeUploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

    echo "<p>Vaccines:</p><br>";
    $query = "SELECT vaccineUploadID, name FROM vaccineUpload";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($vaccineUploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?vaccineUploadID=$vaccineUploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['vaccineUploadID'])){
        $vaccineUploadID    = $_GET['vaccineUploadID'];
        $query = "SELECT name, type, size, content FROM vaccineUpload WHERE vaccineUploadID= '$vaccineUploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

    echo "<p>Permits:</p><br>";
    $query = "SELECT permitUploadID, name FROM permitUpload";
    $result = mysqli_query($conn, $query) or die('Error, query failed');

    if(mysqli_num_rows($result)==0){
        echo "Database is empty <br>";
    }
    else{
        while(list($permitUploadID, $name) = mysqli_fetch_array($result)){
            echo "<a href=\"download.php?permitUploadID=$permitUploadID\">$name</a><br>";
        }
    }

    if(isset($_GET['permitUploadID'])){
        $permitUploadID    = $_GET['permitUploadID'];
        $query = "SELECT name, type, size, content FROM permitUpload WHERE permitUploadID= '$permitUploadID'";
        $result = mysqli_query($conn, $query) or die('Error, query failed');
        list($name, $type, $size, $content) =  mysqli_fetch_row($result);
        header("Content-Disposition: attachment; filename=\"$name\"");
        header("Content-type: $type");
        header("Content-length: $size");
        print $content;
    }

?>