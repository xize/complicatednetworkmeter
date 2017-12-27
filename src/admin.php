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

use complicatednetworkmeter\install;

namespace complicatednetworkmeter {
    session_start();

    require_once("config.php");

    class AdminPortal {

        /**
        * checks if the user is logged in
        *
        * @author xize
        */
        public function isLoggedIn() {
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
                return true;
            }
            return false;
        }

        /**
        * updates the username
        *
        * @author xize
        */
        public function updateUsername($oldname, $username) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
               $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB()); 
               $stmt = $sql->prepare("UPDATE name FROM users WHERE name=? SET name=?");
               $stmt->bind_param("ss", $oldname, $username);
               $bol = $stmt->execute();
               $stmt->close();
               return $bol;
            }
            return false;
        }

        /**
        * updates the password
        *
        * @author xize
        */
        public function updatePassword($username, $oldpassword, $password) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
                $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB());
                $stmt = $sql->prepare("UPDATE password FROM users WHERE name=? AND password=? SET password=?");
                $stmt->bind_param("sss", $username, $this->encrypt($oldpassword), $this->encrypt($password);
                $bol = $stmt->execute();
                $stmt->close();
                return $bol;
            }
            return false;
        }

        /**
        * returns all the devices from the database
        *
        * @author xize
        */
        public function getAllDevices() {
            $cfg = new \Config();
            if($cfg instanceof Config) {
                $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB());
                $stmt = $sql->prepare("SELECT * FROM monitor ORDER by date");
                $rows = $stmt->execute();
                $stmt->close();
                
                $devices = array();

                foreach($rows as $row) {
                    $name = $row['name'];
                    $dns = $row['dns'];
                    $ping = $row['ping'];
                    $monitor = new MonitorAPI(array($name,$dns,$ping));
                    array_push($devices, $monitor);
                }
                return $devices;
            }
            return null;
        }

        /**
        * returns the device by name
        *
        * @author xize
        */
        public function getDeviceByName($name) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
                $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB());
                $stmt = $sql->prepare("SELECT * FROM monitor WHERE name=?");
                $stmt->bind_param("s", $name);
                $data = $stmt->execute();
                $stmt->close();
                $monitor = new MonitorAPI(array($data['name'], $data['dns'], $data['ping']));
                return $monitor;
            }
            return null;
        }

        /**
        * disables a device by name
        *
        * @author xize
        */
        public function disableDevice($name) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
                $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB());
                $stmt = $sql->prepare("UPDATE monitor WHERE name=? SET disabled=?");
                $stmt->bind_param("ss", $name, "true");
                $stmt->execute();
                $stmt->close();
                return true;
            }
            return false;
        }

        /**
        * removes a device by name
        *
        * @author xize
        */
        public function removeDevice($name) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
                $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB());
                $stmt = $sql->prepare("DELETE FROM monitor WHERE name=?");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $stmt->close();
            }
            return false;
        }

        /**
        * encrypts the password into something considered to be 'uncrackable'
        *
        * @author xize
        */
        private function encrypt($password) {
            $salted = $salted = \Salt::getGenerator()->createSalt($password, 2048);
            $ivlength = openssl_cipher_iv_length($cipher="AES-256-CBC");
            $iv = openssl_random_pseudo_bytes($ivlength);
            $encrypted = openssl_encrypt($salted, $cipher, $options=OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $encrypted, true);
            $finalpass = base64_encode($hmac.$encrypted);
            return $finalpass;
        }
    }
}

