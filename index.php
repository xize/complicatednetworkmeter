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
    require_once("indexclass.php");
?>

<!DOCTYPE html>
<head>
    <title>CNM - complicatednetworkmeter</title>
    <style>
        body {
            font-family:helvetica, verdana;
            font-size:8pt;
            color:lightblue;
        }

        .error {
            color:red;
            font-weight:bold;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
            text-align:center;
        }

        .center10pr {
            width:470px;
            margin-left: auto;
            margin-right: auto;
        }

        h3 {
            font-size:16pt;
        }

        h4 {
            color:white;

        }

        .monitorblock {
            float:left;
            width:200px;
            height:200px;
            margin-right:30px;
            margin-top:30px;
            color:white;
            border-radius:8px;
            box-shadow: 0px 8px 0px 0px darkgray;
        }

        .container {
            float:left;
            width:100%;
            height:100%;
        }

        .clear {
            clear:both;
        }

        .close {
            float:right;
            cursor: pointer;
            color:white;
            font-size:14pt;
            font-weight:bold;
            margin:8px;
            clear:both;
        }

        button {
            border-radius:8px;
            background:lightblue;
            color:white;
            padding:10px;
            border:none;
            cursor:pointer;
            margin:3px;
        }

        button:hover {
            background:; blue;
        }

        textarea {
            margin-top:20px;
            font-family: helvetica, verdana;
            font-size:8pt;
        }

        hr {
            border:3px dotted lightblue;
        }

    </style>
</head>
    <body>

        <div class="container center"/>
            <h1>CNM global service status:</h1>
            <?php 
                $content = new BaseContent();
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