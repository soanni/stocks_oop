<?php
    include_once '../helpers/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Import rates</title>
        <meta charset="utf-8"/>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css"/>
    </head>
    <body>
        <h1>Rates upload page</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="..">Back..</a></li>
            </ul>
        </nav>
        <form action="index.php">
            <label for="file" style="font-size: medium">Select file:</label>
            <input type="file" id="files" name="files[]" multiple/>
            <input type="submit" value="Upload">
        </form>
    </body>
</html>
