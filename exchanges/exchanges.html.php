<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Manage Exchanges</title>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="?addexchange">Add exchange</a></li>
				<li><a href="..">Back..</a></li>
			</ul>
		</nav>
		<p>Here are all the exchanges in the database:</p>
		<ul>
			<?php foreach ($exchanges as $exchange): ?>
				<li>
					<form action="" method="post">
						<div class="exchange">
							<?php 
								htmlout($exchange->getName());
							?>
							<input type="hidden" name="id" value="<?php htmlout($exchange->getId()); ?>">
							<input type="submit" name="action" value="Edit">
							<input type="submit" name="action" value="Delete">
						</div>
					</form>
				</li>
			<?php endforeach; ?>
		<ul>
		<?php include '../logout.inc.html.php'; ?>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/common.js"></script>
	</body>
</html>