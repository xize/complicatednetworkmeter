<?php
/*
Copyright 2017 Guido Lucassen

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

use complicatednetworkmeter\api;

namespace complicatednetworkmeter\admin {
    require_once("adminportal.php");
    require_once("../api/monitorapi.php");

    $portal = new \AdminPortal();
?>
<!DOCTYPE html>
<head>
    <title>CNM - complicatednetworkmeter</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
    <body>
        <div class="container center"/>
            <h1>CNM monitor administration</h1>
            <?php
                if($portal->isLoggedIn()) {
                    foreach($portal->getDevices() as $device) {
                        if($device instanceof MonitorAPI) {
                            echo "<div class=\"device\"/>";
                            echo "  <div class=\"close\"/>x</div>";
                            echo "  ";          
                            echo "</div>";    
                        }
                    }
                } else {
                    if(isset($_POST['username']) && isset($_POST['password'])) {
                        $username = $_POST['username'];
                        $password = $portal->encrypt($_POST['password']);

                        if($username == $portal->getUsername()) {
                            if($password == $portal->getPassword()) {

                            } else {
                                
                            }
                        } else {

                        }

                    } else {
                        echo "<div class=\"login\"/>";
                        echo "  <form name=\"login\" method=\"post\" action=\"\"/>";
                        echo "      <p>username: <input type=\"text\" name=\"username\" value=\"username\"/></p>";
                        echo "      <p>password: <input type=\"password\" name=\"password\" value=\"password\"/></p>";
                        echo "      <p><input type=\"submit\" value=\"login!\"/></p>";
                        echo "  </form>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </body>
</html>
<?php
}
?>