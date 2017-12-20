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
            width:100%;
            height:100%;
            margin:0;
            padding:0;
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

        h3 {
            font-size:16pt;
        }

        h4 {
            color:white;

        }

        .monitorblock {
            display:block;
            float:left;
            width:30%;
            margin:30px;
            color:white;
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