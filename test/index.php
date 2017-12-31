<?php
/**
Copyright 2018 Guido Lucassen

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

namespace metertest {

    class TestContent {
        
        /**
        * shows the list with all tests
        *
        * @author xize
        */
        public function showList() {
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
        }
    }
    $test = new TestContent();
    $test->showList();
}