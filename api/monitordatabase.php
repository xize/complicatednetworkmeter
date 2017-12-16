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

use complicatednetworkmeter;

namespace complicatednetworkmeter\api {

	class MonitorDatabase {
		public void addToDatabase($name = "", $dns = false, $ping = false) {
			if(strlen($name) > 0) {
				
				$cfg = new Config();
				$sql = new Mysqli($cfg->dbhost, $cfg->dbuser, $cfg->dbpass, $cfg->db);
				if(mysqli_errno()) {
					printf("Connection to database failed: %s!\n", mysqli_connect_error());
					exit();
				}
				
				$stmt1 = $sql->prepare("DELETE FROM monitor WHERE name=?");
				$stmt1->bind_param("s", $name);
				$stmt1->execute();
				
				$stmt2 = $sql->prepare("INSERT INTO monitor (name, dns, ping, date) VALUES(?, ?, ?, ?)");
				$stmt2->bind_param("ssss", $name, (string)$dns, (string)$ping, date("Ymd"));
				$stmt2->execute();
				$sql->close();
			} else {
				//throw 503 here since we do not fill our database with empty objects!
				header('HTTP/1.1 503 Service Temporarily Unavailable');
				header('Status: 503 Service Temporarily Unavailable');
				header('Retry-After: 300');//300 seconds
			}
		}	
	}
}