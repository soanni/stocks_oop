<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Manage Countries</title>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="?addcountry">Add country</a></li>
				<li><a href="..">Back..</a></li>
			</ul>
		</nav>
		<p>Here are all the countries in the database:</p>
		<ul>
			<?php foreach ($countries as $country): ?>
				<li>
					<form action="" method="post">
						<div>
							<?php htmlout($country->getCountryName().' '); ?>
							<?php htmlout($country->getCountryAcronym()); ?>
							<input type="hidden" name="id" value="<?php echo $country->getCountryId(); ?>"></th>
							<input type="submit" name="action" value="Edit">
							<input type="submit" name="action" value="Delete">
						</div>
					</form>
				</li>
			<?php endforeach; ?>
		<ul>
		<?php include '../logout.inc.html.php'; ?>
	</body>
	<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>
</html>