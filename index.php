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
	if(!file_exists("config.php")) {
		header("Location: /install/");
	} else {
		require_once("config.php");
		$cfg = new Config();
		if($cfg->IsMonitor()) {
			//register url listener which stores the latest activity
			
			//check data from database.
		
			//represent data from the database
		} else {
			//retrieves the main monitor node from the config
		
			//performs tests to DNS and other upstream services PING, and DNS (reads from upstream.yml)
		
			//after the tests have been completed grab the monitor url from the config or reuse the same url address which should be a static ip and sent a API url request to the monitor node
			//this url will contain a detailed stroke of information to what is offline or not.
		}
	}
}