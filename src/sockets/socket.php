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

namespace complicatednetworkmeter\sockets {

    abstract class MonitorSocket {

        protected $ip;

        /**
        * the constructor
        *
        * @param ip - the ip address either the host ip or the ip where the client needs to connect to.
        * @author xize
        */
        public function __construct($ip) {
            $this->ip = $ip;
        }

        /**
        * either connects to a server, or hosts as server
        *
        * @author xize
        */
        public abstract function connect();

        /**
        * returns true if the socket is running either being as host or as client
        *
        * @author xize
        */
        public abstract function isConnected();

        /**
        * disconnects the host or the client
        *
        * @author xize
        */
        public abstract function disconnect();
    }

}