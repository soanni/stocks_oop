<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Manage Rates</title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
        <link href="../js//DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Quotes Rates</h1>
        <nav>
            <ul>
                <li><a href="?addrate">Add rate</a></li>
                <li><a href="import.html.php">Import(CSV)</a></li>
                <li><a href="..">Back..</a></li>
                <li class="topofpage"><a href="#">Top of page</a></li>
            </ul>
        </nav>
        <table id="rates">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Company</th>
                    <th>Quote</th>
                    <th>SECID</th>
                    <th>Date open-rate</th>
                    <th>Date close-rate</th>
                    <th>Date min</th>
                    <th>Date max</th>
                    <th>Last deal</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>
            </thead>
        </table>
        <?php include '../logout.inc.html.php'; ?>

        <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="../js/jquery.scrollTo.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../js/DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../js/common.js"></script>
    </body>
</html>