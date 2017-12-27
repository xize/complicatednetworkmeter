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

	require_once("monitorapi.php");

	class MonitorDatabase {

		/**
		* Adds the data into the database, this will be updated once one of the devices hitted our url.
		*
		* @author xize
		* @param name - the name of the service being called
		* @param dns - the status of the dns server for this service
		* @param ping - the status of the ping command being used by this service
		*/
		public function addToDatabase($name = "", $dns = false, $ping = false) { //add type check.
			if(strlen($name) > 0) {
				
				$cfg = new Config();
				$sql = new Mysqli($cfg->dbhost, $cfg->dbuser, $cfg->dbpass, $cfg->db);
				if(mysqli_errno()) {
					printf("Connection to database failed: %s!\n", mysqli_connect_error());
					exit();
				}
				

				//if it finds the table, it will update the table if not a new table is getting created, this will fix performance issues.
				$date = date("Ymd");
				$stmt = $sql->prepare("SELECT * FROM monitor WHERE EXISTS (SELECT * FROM monitor WHERE name=?) THEN UPDATE monitor SET name=?, dns=?, ping=?, date=? WHERE name=? ELSE INSERT INTO monitor(name, dns, ping, date) VALUES(?, ?, ?, ?) END");
				$stmt->bind_param("ssssssssss", $name, $name, $dns, $ping, $date, $name, $name, $dns, $ping, $date);
				$stmt.execute();
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