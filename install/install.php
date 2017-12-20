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

namespace complicatednetworkmeter\install {

    require_once("license.php");

    class Install {

        /**
        * returns the page routing and content for the installscript.
        *
        * @author xize
        */
        public function getContent() {
            echo "<div class=\"content\"/>";
            if(!isset($_GET['step'])) {
                echo "<h3>welcome to CNM please accept the terms!</h3>";
                echo "<hr>";
                $license = new License();
                echo "<p><textarea rows=\"20\" cols=\"120\"/>" . $license->getLicenseAgreement() . "</textarea></p>";
                echo "<p><button onclick=\"open(location, '_self').close()\">close</button><button onclick=\"window.location.href='?step=1'\">I agree with the license</button></p>";
            } else {
                switch($_GET['step']) {
                    case "1":
                        echo "<h3>please fill in your database settings!</h3>";
                        echo "<hr>";
                        echo "<form name=\"dbsettings\" method=\"post\" action=\"?step=2\"/>";
                        echo "  <p>db username: <input type=\"text\" name=\"dbuser\"/></p>";
                        echo "  <p>db password: <input type=\"password\" name=\"dbpasswd\"/></p>";
                        echo "  <p>database name: <input type=\"text\" name=\"dbname\"/></p>";
                        echo "<p><button onclick=\"window.location.href='?step=index'\")\">back</button><button type=\"submit\">next</button></p>";
                        echo "</form>";
                    break;
                    case "2":
                        if(isset($_POST['dbuser']) && strlen($_POST['dbuser']) > 0 && isset($_POST['dbpasswd']) && strlen($_POST['dbpasswd']) > 0 && isset($_POST['dbname']) && strlen($_POST['dbname']) > 0) {
                            echo "<h3>please check if the database connection succeeded!</h3>";
                            echo "<hr>";
                            echo "<p><button>check database connection!</button></p>";
                            echo "<p><button onclick=\"window.location.href='?step=1'\">back</button><button onclick=\"window.location.href='?step=3'\">next</button></p>";
                        } else {
                            echo "<h3>error: one of the forms was empty or not filled in!</h3>";
                            echo "<hr>";
                            echo "<p class=\"error\">you get redirected back to the previous page in 10 seconds!</p>";
                            header("refresh:10;URL=?step=1");
                        }
                    break;
                    case "3":
                        echo "<h3>please create a administrator account!</h3>";
                        echo "<hr>";
                        echo "<form name=\"account\" method=\"post\"/>";
                        echo "  <p>username: <input type=\"text\" name=\"user\" value=\"username\"/></p>";
                        echo "  <p>password: <input type=\"password\" name=\"password\" value=\"password\"/></p>";
                        echo "  <p>re-type password: <input type=\"password\" name=\"password2\" value=\"password\"/></p>";
                        echo "</form>";
                        echo "<p><button onclick=\"window.location.href='?step=2'\">back</button><button onclick=\"window.location.href='?step=4'\">next</button></p>";
                    break;
                    default:
                        header("Location: /index.php");
                    break;
                }
            } 
            echo "</div>";
        }
    }
}