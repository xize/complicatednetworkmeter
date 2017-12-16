<?php
namespace complicatednetworkmeter\api {

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
}