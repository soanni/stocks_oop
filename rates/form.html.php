<?php
	include_once '../helpers/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($pageTitle); ?></title>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
		<link href = "../js/jquery-ui/jquery-ui.min.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<h1><?php htmlout($pageTitle); ?></h1>
		<form id="addrate" action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="quote">Quote: </label> 
				<select name = "quote" id="quote">
					<option value="">Select one</option>
					<?php foreach ($quotes as $quote): ?>
						<option value="<?php htmlout($quote['qid']); ?>"
							<?php
								if ($quote['qid'] == $quoteid){
									echo ' selected';
								}
							?>>
							<?php 
								htmlout($quote['fullname']); 
								//$company = $quote['companyname'];
								//$country = $quote['countryname'];
							?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="company">Company: </label> 
				<input type="text" name="company" id="company" value="<?php htmlout($company); ?>" readonly>
			</div>
			<div>
				<label for="country">Country: </label> 
				<input type="text" name="country" id="country" value="<?php htmlout($country); ?>" readonly>
			</div>
			<div>
				<label for="openrate">Open rate: </label> 
				<input type="number" name="openrate" id="openrate" value="<?php htmlout($openrate); ?>" step="<?php htmlout($step);?>">
			</div>
			<div>
				<label for="closerate">Close rate: </label> 
				<input type="number" name="closerate" id="closerate" value="<?php htmlout($closerate); ?>" step="<?php htmlout($step);?>">
			</div>
			<div>
				<label for="ratedate">Rate date: </label> 
				<input type="text" name="ratedate" id="ratedate" value="<?php htmlout($ratedate); ?>">
			</div>
			<div>
				<label for="dayminimum">Day minimum: </label> 
				<input type="number" name="dayminimum" id="dayminimum" value="<?php htmlout($dayminimum); ?>" step="<?php htmlout($step);?>">
			</div>
			<div>
				<label for="daymaximum">Day maximum: </label> 
				<input type="number" name="daymaximum" id="daymaximum" value="<?php htmlout($daymaximum); ?>" step="<?php htmlout($step);?>">
			</div>
			<div>
				<input type="hidden" name="rateid" value="<?php htmlout($id); ?>">
				<input type="submit" value="<?php htmlout($button); ?>">
			</div>
		</form>
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../js/date.js"></script>
		<script type="text/javascript" src="script.js"></script>
	</body>
</html>