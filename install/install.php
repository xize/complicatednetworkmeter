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

        private $duser;
        private $dpass;
        private $db;

        /**
        * returns the page routing and content for the installscript.
        *
        * @author xize
        */
        public function getContent() {
            echo "<div class=\"content\"/>";
            if(!isset($_GET['step'])) {
                if(isset($_COOKIE['agreed'])) {
                    $this->showError("License was already agreed! :D", "you already agreed to the license, redirecting in 5 seconds!");
                    header("refresh:5;URL=?step=1");
                    return;
                }
                echo "<h3>welcome to CNM please accept the terms!</h3>";
                echo "<hr>";
                $license = new License();
                echo "<p><textarea rows=\"20\" cols=\"120\"/>" . $license->getLicenseAgreement() . "</textarea></p>";
                echo "<p><button onclick=\"open(location, '_self').close()\">close</button><button onclick=\"window.location.href='?step=1'\">I agree with the license</button></p>";
            } else {
                switch($_GET['step']) {
                    case "1":
                        setcookie("agreed", +3600);
                        if(isset($_COOKIE['sqlsucceed'])) {
                            header("Location: ?step=3");
                        }
                        echo "<h3>please fill in your database settings!</h3>";
                        echo "<hr>";
                        echo "<form name=\"dbsettings\" method=\"post\" action=\"?step=2\"/>";
                        echo "  <p>db username: <input type=\"text\" name=\"dbuser\"/></p>";
                        echo "  <p>db password: <input type=\"password\" name=\"dbpasswd\"/></p>";
                        echo "  <p>database name: <input type=\"text\" name=\"dbname\"/></p>";
                        echo "<p><button onclick=\"window.location.href='index.php'\")\">back</button><button type=\"submit\">next</button></p>";
                        echo "</form>";
                    break;
                    case "2":
                        if(isset($_POST['dbuser']) && strlen($_POST['dbuser']) > 0 && isset($_POST['dbname']) && strlen($_POST['dbname']) > 0) {
                            echo "<h3>please check if the database connection succeeded!</h3>";
                            echo "<hr>";
                            echo "<p>testing connection...</p>";
                            $con = $this->testConnection("localhost", $_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname']);
                            if($con) {
                                setcookie("sqlsucceed", +3600);
                                //create database...
                                echo $con ? "<p style=\"color:green\">[+] the connection was successfull</p>" : "<p style=\"color:red\">[x] the connection failed!</p>";
                                echo "<p>creating database now...</p>";
                                if($this->createDatabase("localhost", $_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname'])) {
                                    echo "<p style=\"color:green\">[+] database created with success!</p>";
                                    if($this->addTables("localhost", $_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname'])) {
                                        echo "<p style=\"color:green\">[+] tables are successfully created!</p>";
                                    } else {
                                        echo "<p style=\"color:red\">[x] failed to add tables!</p>";
                                        unset($_COOKIE['sqlsucceed']);
                                    }
                                } else {
                                    echo "<p style=\"color:red\">[x] failed to create database!</p>";
                                    unset($_COOKIE['sqlsucceed']);
                                }
                                //end creating database

                                //no need to use sessions here we store the values in local variables.
                                $this->duser = $_POST['dbuser'];
                                $this->dpass = $_POST['dbpasswd'];
                                $this->db = $_POST['dbname'];
                            } else {
                                echo "<p style=\"color:red\">[x] unable to connect to the database!, please fill in your settings again</p>";
                                unset($_COOKIE['sqlsucceed']);
                            }
                            echo "<p><button onclick=\"window.location.href='?step=1'\">back</button>". (isset($_COOKIE['sqlsucceed']) ? "<button onclick=\"window.location.href='?step=3'\"/>next</button>" : "")."</p>";
                        } else {
                            $this->showError("one of the forms was empty or not filled in!", "you get redirected back to the previous page in 10 seconds!");
                            header("refresh:10;URL=?step=1");
                        }
                    break;
                    case "3":
                        if(!isset($_COOKIE['sqlsucceed'])) {
                            $this->showError("no cookies found!", "you get redirected back to the previous page in 10 seconds!");
                            header("refresh: 10;URL=index.php");
                            return;
                        }
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

        /**
        * returns true if the connection succeeded otherwise false.
        *
        * @author xize
        */
        public function testConnection($network, $user, $password) {
            if(mysqli_connect($network, $user, $password)) {
                return true;
            }
            return false;
        }

        /**
        * creates the database specified on the credentials given in
        *
        * @author xize
        */
        public function createDatabase($network, $user, $password, $db) {
            $sql = new \mysqli($network, $user, $password);
            $stmt = $sql->prepare("CREATE DATABASE IF NOT EXISTS " . $db . "");
            if($stmt->execute()) {
                return true;
            }
            return false;
        }

        /**
        * creates the tables in the new database
        *
        * @author xize
        */
        public function addTables($network, $user, $password, $db) {
            $sql = new \mysqli($network, $user, $password, $db);
            $stmt = $sql->prepare("
                CREATE TABLE IF NOT EXISTS `monitor` (
                    `id` int(254) NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    `dns`  varchar(8) NOT NULL,
                    `ping` varchar(8) NOT NULL,
                    PRIMARY KEY(`id`),
                    KEY `name` (`name`)
                )");
            return $stmt->execute();
        }

        /**
        * formats a error
        *
        * @author xize
        */
        public function showError($title, $text) {
            echo "<h3>error: ". $title ."</h3>";
            echo "<hr>";
            echo "<p class=\"error\">" . $text . "</p>";
        }
    }
}