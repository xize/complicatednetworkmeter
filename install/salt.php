
<?php
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
    class Salt {

        private static $generator;
        protected function __construct() {} //allow the class to be instanced only by it self.

        public static function getGenerator() {
            if(SELF::$generator instanceof Salt) {
                return SELF::$generator;
            }
            SELF::$generator = new Salt();
            return SELF::$generator;
        }
        
        public function createSalt($password, $bits) {
            //turns password into a bytearray
            $bytes = unpack("C*", $password);
            //create seed by adding the bytes near each other.
            $seed = '';
            foreach($bytes as $byte) {
              $seed .= $byte;
            }
            //instancing generator with seed.
            srand($seed);
            //shuffle current bytes on seed.
            $this->shuffle($bytes);
            //addbytes and reshuffle the bytes in the array!
            $this->addBytes($bytes, $bits);
            $salt = '';
            foreach($bytes as $byte) {
              $salt .= chr($byte);
            }
            return $salt;
        }

        private function shuffle(&$array) {
            foreach($array as $index) {
                $newarray[$index] = $array[rand(1, (count($array)-1))]; //rand() default php function uses the psuodo seed we instanced earlier, note that mt_srand is not and very slow when the password is longer, which is a sign of bad things in any like hood of encryption it makes it vulnerable when the password almost matched, because it went slower, its also not encouraged to use this script as a kind of encryption mechanism.
            }
            $array = $newarray;
        }

        private function addBytes(&$array, $bits) {
            for($i = 0; $i < $bits; $i++) {
                $newarray[$i] = rand(0, 127); //respectable only generate between 0 and 127 (total: 128) to hold UTF-8 compatibility
            }
            $array = array_merge($array, $newarray);
            $this->shuffle($array);
        }
    }
}