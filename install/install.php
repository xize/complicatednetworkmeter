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

    session_start();

    require_once("license.php");
    require_once("salt.php");

    class Install {


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
                                $_SESSION['network'] = "localhost";
                                $_SESSION['user'] = $_POST['dbuser'];
                                $_SESSION['pass'] = $_POST['dbpasswd'];
                                $_SESSION['db'] = $_POST['dbname'];
                                
                                //create database...
                                echo $con ? "<p style=\"color:green\">[+] the connection was successfull</p>" : "<p style=\"color:red\">[x] the connection failed!</p>";
                                echo "<p>creating database now...</p>";
                                if($this->createDatabase("localhost", $_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname'])) {
                                    echo "<p style=\"color:green\">[+] database created with success!</p>";
                                    if($this->addTables("localhost", $_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname'])) {
                                        echo "<p style=\"color:green\">[+] tables are successfully created!</p>";
                                    } else {
                                        echo "<p style=\"color:red\">[x] failed to add tables!</p>";
                                        unset($_SESSION['network']);
                                        unset($_SESSION['user']);
                                        unset($_SESSION['password']);
                                        unset($_SESSION['db']);
                                        
                                        session_destroy();
                                    }
                                } else {
                                    echo "<p style=\"color:red\">[x] failed to create database!</p>";
                                    unset($_SESSION['network']);
                                    unset($_SESSION['user']);
                                    unset($_SESSION['password']);
                                    unset($_SESSION['db']);    
                                    session_destroy();
                                }
                                //end creating database
                            } else {
                                echo "<p style=\"color:red\">[x] unable to connect to the database!, please fill in your settings again</p>";
                                    unset($_SESSION['network']);
                                    unset($_SESSION['user']);
                                    unset($_SESSION['password']);
                                    unset($_SESSION['db']);    
                                    session_destroy();

                            }
                            if(isset($_SESSION['network'])) {
                                echo "<p><button onclick=\"window.location.href='?step=1'\">back</button><button onclick=\"window.location.href='?step=3'\"/>next</button></p>";
                            } else {
                                echo "<p><button onclick=\"window.location.href='?step=1'\">back</button></p>";
                            }
                        } else {
                            $this->showError("one of the forms was empty or not filled in!", "you get redirected back to the previous page in 10 seconds!");
                            header("refresh:10;URL=?step=1");
                        }
                    break;
                    case "3":
                        if(!isset($_SESSION['user'])) {
                            $this->showError("no active session found!", "you get redirected back to the previous page in 10 seconds!");
                            header("refresh: 10;URL=index.php");
                           return;
                        }
                        echo "<h3>please create a administrator account!</h3>";
                        echo "<hr>";
                        echo "<form name=\"account\" method=\"post\" action=\"?step=4\"/>";
                        echo "  <p>username: <input type=\"text\" name=\"cms_user\" value=\"username\"/></p>";
                        echo "  <p>password: <input type=\"password\" name=\"cms_password\" value=\"password\"/></p>";
                        echo "  <p>re-type password: <input type=\"password\" name=\"password2\" value=\"password\"/></p>";
                        echo "  <p>is monitor?: <input type=\"checkbox\" name=\"monitor\"/></p>";
                        echo "<p><button onclick=\"window.location.href='?step=2'\">back</button><button type=\"submit\" onclick=\"window.location.href='?step=4'\">next</button></p></form>";
                    break;
                    case "4":
                        if(isset($_POST['cms_user']) && isset($_POST['cms_password'])) {
                            if($_POST['cms_password'] != $_POST['password2']) {
                                $this->showError("passwords did not match!", "you get redirected to the previous page over 5 seconds!");
                                header("refresh:5;URL=?step=3");
                                return;
                            }

                            $this->createConfig();

                            echo "<h3>successfully created login information!</h3>";
                            echo "<hr>";
                            echo "<p>please click <a href=\"../admin.php\"/>here</a> to login to your admin panel!</p>";
                            if($_POST['monitor']) {
                                $_SESSION['ismonitor'] = true;
                            } else {
                                $_SESSION['ismonitor'] = false;
                            }

                            $this->createUser($_SESSION['network'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['db'], $_POST['cms_user'], $_POST['cms_password']);
                        } else {
                            showError("failed to create user empty forms!", "we redirect you to the previous page in 5 seconds!");
                            header("refresh:5;URL=?step=3");
                        }
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
                    UNIQUE `monitor` (name),
                    KEY `name` (`name`)
                )");
            $stmt2 = $sql->prepare("
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` int(254) NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    `password`  varchar(100) NOT NULL,
                    PRIMARY KEY(`id`),
                    UNIQUE `users` (name),
                    KEY `name` (`name`)
                )");
            return $stmt->execute() && $stmt2->execute();
        }

        /**
        * creates the user with a strong encrypted password based on AES-256-CBC and salted.
        *
        * @author xize
        */
        public function createUser($network, $user, $password, $db, $cms_user, $cms_password) {
            $sql = new \mysqli($network, $user, $password, $db);
            $stmt = $sql->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
            $finalpass = $this->encrypt($cms_password);
            $stmt->bind_param("ss", $cms_user, $finalpass);
            $stmt->execute();
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

        /**
        * encrypts the password into something considered to be 'uncrackable'
        *
        * @author xize
        */
        public function encrypt($password) {
            $salted = $salted = \Salt::getGenerator()->createSalt($password, 2048);
            $ivlength = openssl_cipher_iv_length($cipher="AES-256-CBC");
            $iv = openssl_random_pseudo_bytes($ivlength);
            $encrypted = openssl_encrypt($salted, $cipher, $options=OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $encrypted, true);
            $finalpass = base64_encode($hmac.$encrypted);
            return $finalpass;
        }

        /**
        * creates the configuration file for connection
        *
        * @author xize
        */
        public function createConfig() {

            $file = fopen("../config.php", "w");
            
            $txt = "<?php
/*
Copyright 2017 Guido Lucassen

Licensed under the Apache License, Version 2.0 (the \"License\");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an \"AS IS\" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

namespace complicatednetworkmeter {
                    
    private \$network;
    private \$user;
    private \$password;
    private \$db;
    private \$ismonitor;

    class Config {

        public function __construct() {
            \$this->network = \"". $_SESSION['network'] ."\";
            \$this->user = \"". $_SESSION['user'] ."\";
            \$this->password = \"". $_SESSION['pass'] ."\";
            \$this->db = \"". $_SESSION['db'] ."\";
            \$this->ismonitor = \"". $_SESSION['ismonitor'] ."\";
        }

        /**
        * returns the name of the network
        *
        * @author xize
        */
        public function getNetwork() {
            return \$this->network;
        }

        /**
        * returns the username for the database
        *
        * @author xize
        */
        public function getUser() {
            return \$this->user;
        }

        /**
        * returns the password for the database
        *
        * @author xize
        */
        public function getPassword() {
            return \$this->password;
        }

        /**
        * returns the name of the database
        *
        * @author xize
        */
        public function getDB() {
            return \$this->db;
        }

        /**
        * returns true if the server is an monitor or a slave.
        *
        * @author xize
        */
        public function isMonitor() {
            return \$this->ismonitor;
        }
    }
}";

            fwrite($file, $txt);
            fclose($file);
        }
    }
}