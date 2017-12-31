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

namespace complicatednetworkmeter\scheduler {

    require_once("scheduler.php");

    class Task extends Scheduler {
        
        private $f;

        public function __construct($f, $ticks) {
            $this->f = $f;
            $this->setTick($ticks);
        }

        public function run() {
            while($this->isRunning()) {
                sleep($this->getTick());
                $f();
            }
        }
    }

    #test... NOTE: please also make sure this will also keeps looping even if there is no browser window open.
    $task = new Task(function() {

        $i = ($i > 0 ? $i : 0);

        if($i == 8) {
            $this->stop();
            return;
        } else {
            echo "hello world!, this is my ".$i++." visit!";
        }
    }, 3000);
    $task->start();
}