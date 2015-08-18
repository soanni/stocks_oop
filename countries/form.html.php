<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($pageTitle); ?></title>
	</head>
	<body>
		<h1><?php htmlout($pageTitle); ?></h1>
		<form action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="countryname">Country Name: </label> 
				<input type="text" name="countryname" id="countryname" value="<?php htmlout($countryname); ?>">
			</div>
			<div>
				<label for="acronym">Acronym: </label> 
				<input type="text" name="acronym" id="acronym" value="<?php htmlout($acronym); ?>">
			</div>
			<div>
				<input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" value="<?php htmlout($button); ?>">
			</div>
		</form>
	</body>
</html>