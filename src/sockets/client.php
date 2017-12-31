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

use complicatednetworkmeter;
use complicatednetworkmeter\scheduler;

namespace complicatednetworkmeter\sockets {
    
    require_once("../config.php");
    require_once("socket.php");
    require_once("../scheduler/task.php");

    class Client extends MonitorSocket {

        private $task;
        private $laststate;

        public function isConnected() {
            if($this->task != null  && $this->task->isRunning()) {
                return $this->laststate;
            }
            return false;
        }

        public function connect() {
            $this->task = new \Task(function() {
                $cfg = new \Config();
                $mainnode = $cfg->getMainNode();
                $additionalpath = ($cfg->hasAdditionalPath() ? $cfg->getAdditionalPath() : "");
                try {
                    $con = fopen("http://".$mainnode."/".$additionalpath."/api/?v=", "r");
                    fclose($con);
                    $this->laststate = true;
                } catch($ex)  {
                    $this->laststate = false;
                }
            }, 100);
        }

        public function disconnect() { 
            $this->task->cancel();
        }
    }

}