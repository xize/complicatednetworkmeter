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
    <title></title>
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
            padding:8px;
            color:white;
        }

        .monitorblock {
            display:block;
            float:left;
            padding-right:50px;
            width:100%;
            height:80px;
            margin-left:auto;
            margin-right:auto;
        }

        .container {
            float:left;
            width:100%;
            height:100%;
            overflow:hidden;
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
            <?php 
                $content = new BaseContent();
                $content->getContent();
            ?>
        </div>
    </body>
</html>
<?php
}
?>