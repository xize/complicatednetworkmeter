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
    require_once("basecontent.php");
    $content = new BaseContent();
?>

<!DOCTYPE html>
<head>
    <title>CNM - complicatednetworkmeter</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
    <body>

        <div class="container center"/>
            <h1>CNM global service status:</h1>
            <?php
                $content->getContent();
            ?>
        </div>
        <script>
            function windowclose(d) {
                d.parentElement.style.display = 'none';
            }
        </script>
    </body>
</html>
<?php
}
?>