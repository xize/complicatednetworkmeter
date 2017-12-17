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

class Install {

	public function getContent() {
		echo "<div class=\"content\"/>;
		if(!isset($_GET['step'])) {
			echo "<h3>welcome to complicatednetworkmeter please accept the terms!</h3>";
			echo "<hr>";
			echo "<p><textarea width=\"200\" height=\"200\"/></textarea></p>";
			echo "<p><button onclick=\"javascript:window.close()\">close</button><button onclick=\"javascript:navigate("?step=1")\">I agree with the license</button></p>";
		} else if(is_integer($_GET['step'])) {
			switch($_GET['step']) {
				case 1:
					echo "<h3>please fill in your database settings!</h3>";
					echo "<hr>";
					echo "<form name=\"dbsettings\" method=\"post\" action=\"\"/>";
					echo "	<p>db username: <input type=\"text\" name=\"dbuser\" value=\"user\"/></p>";
					echo "	<p>db password: <input type=\"password\" name=\"dbpasswd\" value=\"password\"/></p>";
					echo "	<p>database name: <input type=\"text\" name=\"dbname\" value=\"database\"/></p>";
					echo "	<p><button onclick=\"javascript:navigate(\"index.php\")\">back</button><input type=\"button\" value=\"next\"/></p>";
					echo "</form>";
				break;
				case 2:
				break;
				case 3:
				break;
				default:
					header("Location: index.php");
				break;
			}
		} else {
			header("Location: index.php");
		}
		echo "</div>";
	}
}