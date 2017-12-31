<?php
//prevent access to the root directory by using strpos ;-)
if(isset($_GET['test']) && strpos($_GET['test'], "..") === false && strpos($_GET['test'], "./") === false && strpos($_GET['test'], ".\\") === false) {
    include($_GET['test'].".php");
} else {
    
    $files = glob("*.php");
    
    echo "<!DOCTYPE html>";
    echo "<head>";
    echo "  <title>test environment!</title>";
    echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>";
    echo "</head>";
    echo "<body>";
    echo "  <h1>testing environment:</h1>";
    echo "  <p>make sure you never include these inside the CMS itself!</p>";
    echo "  <hr>";
    echo "  <h4>tests:</h4>";
    echo "  <ul>";
    foreach($files as $file) {
        if(strpos($file, "index") === false) {
            $lindex = strrpos($file, ".php");
            echo "<li><a href=\"?test=".substr($file, 0, $lindex)."\"/>".substr($file, 0, $lindex)."</a></li>";
        }
    }
    echo "  </ul>";
    echo "</body>";
    echo "</html>";
}