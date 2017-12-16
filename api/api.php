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

require_once("../config.php");
require_once("monitordatabase.php");


$cfg = new Config();

if($cfg->isMonitor()) {
	if(isset($_GET['v'])) {
	
		$d = $_GET['v'];
	
		//site.com/api.php?v={service};up;down
	
		if(preg_match("^[A-Za-z0-9];{down|up};{down|up}", $d)) {
			//deserialize by using ;
			$data = explode(";", $d);
			$monitor = new MonitorAPI($data);
		} else {
				echo "malformed packet!";
		}
	}	
} else {
	
}

class MonitorAPI extends MonitorDatabase {

	private $servicename;
	private $dns;
	private $pingip;

	public function __construct($data) {
		$this->servicename = $data[0];
		$this->dns = ($data[1] == "up" ? true : false);
		$this->pingip = ($data[2] == "up" ? true : false);
	}

	public function getName() {
		return $this->servicename;
	}
	
	public function isDNSActive() {
		return $this->dns;
	}
	
	public function isPINGActive() {
		return $this->pingip;
	}
	
}