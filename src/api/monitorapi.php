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

namespace complicatednetworkmeter\api {

	require_once("monitordatabase.php");

	class MonitorAPI extends MonitorDatabase {

		private $servicename;
		private $dns;
		private $pingip;

		/**
		* constructs a new MonitorAPI class
		*
		* @author xize
		* @param data - a array where 0 is the service name, 1 contains a string when the dns is up or false, 2 contains a string when the ping command has been succeeded or failed.
		*/
		public function __construct($data) {
			$this->servicename = $data[0];
			$this->dns = ($data[1] == "up" ? true : false);
			$this->pingip = ($data[2] == "up" ? true : false);
		}
	

		/**
		* gets the name of the service we are reading
		*
		* @author xize
		* @return string
		*/
		public function getName() {
			return $this->servicename;
		}
	
		/**
		* returns true if the dns is active false otherwise
		*
		* @author xize
		* @return bool
		*/
		public function isDNSActive() {
			return $this->dns;
		}
	
		/**
		* returns true if the ping request succeeded, otherwise false
		*
		* @author xize
		* @return bool
		*/
		public function isPINGActive() {
			return $this->pingip;
		}
		
	}
}