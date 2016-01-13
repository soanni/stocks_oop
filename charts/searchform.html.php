<?php
	include_once '../helpers/helpers.inc.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Charts by quotes</title>
		<meta charset="utf-8"/>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css"/>
	</head>
	<body>
        <nav>
            <ul>
                <li><a href="..">Back..</a></li>
                <li class="topofpage"><a href="#">Top of page</a></li>
            </ul>
        </nav>
		<p><strong>Select the company(ies)</strong></p>
		<div id="companies_list">
			<div>
				<?php foreach ($companies as $company): ?>
					<div>
						<label for="company<?php htmlout($company['id']);?>">
							<input type="checkbox" name="companies[]" id="company<?php htmlout($company['id']); ?>" value = "<?php htmlout($company['id']); ?>">
							<?php htmlout($company['name']); ?>
						</label>
					</div>
				<?php endforeach; ?>
			</div>
			<div>
				<!--<input type="hidden" name = "action" value="Search">-->
				<input type="submit" value="Search">
			</div>
		</div>
		<div id="chart"></div>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="../js/highstock.js"></script>
        <script type="text/javascript" src="../js/highchart.js"></script>
	</body>
</html>