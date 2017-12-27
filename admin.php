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

namespace complicatednetworkmeter {
    session_start();

    require_once("config.php");

    class AdminPortal {

        /**
        * checks if the user is logged in
        *
        * @author xize
        */
        function isLoggedIn() {
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
        function updateUsername($oldname, $username) {
            $cfg = new \Config();
            if($cfg instanceof Config) {
               $sql = new mysqli($cfg->getNetwork(), $cfg->getUser(), $cfg->getPassword(), $cfg->getDB()); 
               $stmt = $sql->prepare("UPDATE name FROM users WHERE name=? SET name=?");
               $stmt->bind_param("ss", $oldname, $username);
               $stmt->execute();
               $stmt->close();
            }
        }

        /**
        * updates the password
        *
        * @author xize
        */
        function updatePassword($password) {

        }

        /**
        * returns all the devices from the database
        *
        * @author xize
        */
        function getAllDevices() {
            
        }

        /**
        * returns the device by name
        *
        * @author xize
        */
        function getDeviceByName($name) {

        }

        /**
        * disables a device by name
        *
        * @author xize
        */
        function disableDevice($name) {

        }

        /**
        * removes a device by name
        *
        * @author xize
        */
        function removeDevice($name) {

        }

    }
}

