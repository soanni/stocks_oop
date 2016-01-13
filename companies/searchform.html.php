<?php
	include_once '../helpers/helpers.inc.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Manage Companies</title>
		<meta charset="utf-8"/>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<h1>Manage Companies</h1>
		<nav>
			<ul>
				<li><a href="?addcompany">Add company</a></li>
				<li><a href="?">New Search</a></li>
				<li><a href="..">Back..</a></li>
			</ul>
		</nav>
		<form action="" method="get">
			<p><strong>View companies according the following criteria:</strong></p>
			<div>
				<?php foreach ($countries as $country): ?>
					<div>
						<label for="country<?php htmlout($country['id']);?>">
							<input type="checkbox" name="countries[]" id="country<?php htmlout($country['id']); ?>" value = "<?php htmlout($country['id']); ?>"
								<?php
									if ($country['selected']){
										echo ' checked';
									}
								?>
								><?php htmlout($country['name']); ?>
						</label>
					</div>
				<?php endforeach; ?>
			</div>
			<p><strong>View only active companies:</strong></p>
			<div>
				<label>Only Active</label>
				<input type="checkbox" name="activeflag" id = "activeflag" value = "1">
			</div>
			<div>
				<input type="hidden" name = "action" value="Search">
				<input type="submit" value="Search">
			</div>
		</form>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.color-2.1.2.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/common.js"></script>
	</body>
</html>