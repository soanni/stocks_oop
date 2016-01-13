<?php
	include_once '../helpers/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Manage Companies: Search Results</title>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<h1>Search Results</h1>
		<?php if(isset($companies)): ?>
			<table>
			<tr><th>Company</th><th>Country</th><th>Options</th></tr>
			<?php foreach ($companies as $company): ?>
				<tr class = "<?php
								if($company['active'] == 0){
									echo 'noactive';
								}
								elseif($company['active'] == 1){
									echo 'active';
								}
							?>">
					<td><a href ="<?php htmlout($company['web']); ?>"><?php htmlout($company['companyname'].' '); ?></a></td>
					<td><?php htmlout($company['country'].' '); ?></td>
					<td>
						<form action="?" method="post">
							<div>
								<input type="hidden" name="id" value="<?php echo $company['companyid']; ?>"></th>
								<input type="submit" name="action" value="Edit">
								<input type="submit" name="action" value="Delete">
							</div>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
		<?php include '../logout.inc.html.php'; ?>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/common.js"></script>
	</body>
</html>