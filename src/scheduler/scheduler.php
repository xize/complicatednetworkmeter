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

    abstract class Scheduler { 

        private $isrunning = false;
        private $ticks = 0;

        /**
        * starts the scheduler
        *
        * @param ticks - how long it takes before the next tick
        * @author xize
        */
        public function start() {
            $this->isrunning = true;
            $this->run();
        }

        /**
        * returns the tick rate of this scheduler
        *
        * @author xize
        */
        public function getTick() {
            return $this->ticks;
        }

        /**
        * sets the tick rate of this scheduler
        *
        * @author xize
        */
        public function setTick(int $ticks) {
            $this->ticks = $ticks;
        }

        /**
        * returns true if the scheduler is running
        *
        * @author xize
        */
        public function isRunning() {
            return $this->isrunning;
        }

        /**
        * stops the scheduler
        *
        * @author xize
        */
        public function stop() {
            $this->isrunning = false;
        }

        /**
        * the task inside this scheduler
        *
        * @author xize
        */
        public abstract function run();

    }

}