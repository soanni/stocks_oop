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
		<?php if(isset($rates)): ?>
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
                <tbody>
                    <?php foreach ($rates as $rate): ?>
                        <tr class = "<?php
                        if($rate['active'] == 0){
                            echo 'noactive';
                        }
                        elseif($rate['active'] == 1){
                            echo 'active';
                        }
                        ?>">
                            <td><?php htmlout($rate['countryname'].' '); ?></td>
                            <td><a href ="<?php htmlout($rate['web']); ?>"><?php htmlout($rate['companyname'].' '); ?></a></td>
                            <td><?php htmlout($rate['fullname'].' '); ?></td>
                            <td><?php htmlout($rate['acronym'].' '); ?></td>
                            <td><?php htmlout($rate['openrate'].' '); ?></td>
                            <td id="closerate"><?php htmlout($rate['closerate'].' '); ?></td>
                            <td><?php htmlout($rate['dayminimum'].' '); ?></td>
                            <td><?php htmlout($rate['daymaximum'].' '); ?></td>
                            <td><?php htmlout($rate['lastdeal'].' '); ?></td>
                            <td><?php htmlout($rate['ratedate'].' '); ?></td>
                            <td>
                                <form action="?" method="post">
                                    <div>
                                        <input type="hidden" name="id" value="<?php echo $rate['rateid']; ?>"></th>
                                        <input type="submit" name="action" value="Edit">
                                        <input type="submit" name="action" value="Delete">
                                    </div>
                                 </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
			</table>
		<?php endif; ?>
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