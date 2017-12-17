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

use complicatednetworkmeter\api;

namespace complicatednetworkmeter {
	if(!file_exists("config.php")) {
		header("Location: /install/");
	} else {
		$cfg = new Config();
		if($cfg->IsMonitor()) {
			//register url listener which stores the latest activity
			
			include_once("/api/api.php"); //TODO: figuring out if this the right way todo it.... perhaps it needs to be reworked.

			//check data from database.
		
			$sql = new Mysqli($cfg->dbhost, $cfg->dbuser, $cfg->dbpass, $cfg->db);
			$stmt = $sql->prepare("SELECT * FROM Monitor");
			$stmt->execute();
			$data = $stmt->FetchAll();
			$sql->close();

			$monitordata = new array();

			foreach($assoc in $data) {
				$name = $assoc['name'];
				$dns = $assoc['dns'];
				$ping = $assoc['ping'];
				$d = array($name, $dns, $ping);
				$monitor = new MonitorAPI($d);
				array_push($monitordata, $monitor);
			}

			//represent data from the database

			foreach($monitor in $monitordata) {
				
				//add type cast via instanceof, since PHP doesn't have JIT some editors can recognize the MonitorAPI calls via instanceof.
				if($monitor instanceof MonitorAPI) {

					echo "<div class=\"monitorblock\">";
					echo "	<h4 style=\"". ($monitor->isPINGActive() && $monitor->isDNSActive()) ? "background:green;" : "background:red;") ."\">Service: ".$monitor->getName()."</h4>";
					echo "	<div class=\"DNSBLOCK\" style=\"". $monitor->isDNSActive() ? "background:green;" : "background:red;" ."\"/>DNS failed?: ". $monitor->isDNSActive() ? "the dns works" : "the dns failed"."</div>";
					echo "	<div class=\"PINGBLOCK\" style=\"". $monitor->isPINGActive() ? "background:green;" : "background:red;" ."\"/>PING failed?: ". $monitor->isPINGActive() ? "the ping request works" : "the ping request showed indication of packet loss"."</div>";
					echo "</div>";
				}
			}
		} else {
			//retrieves the main monitor node from the config
		
			//performs tests to DNS and other upstream services PING, and DNS (reads from upstream.yml)
		
			//after the tests have been completed grab the monitor url from the config or reuse the same url address which should be a static ip and sent a API url request to the monitor node
			//this url will contain a detailed stroke of information to what is offline or not.
		}
	}
}