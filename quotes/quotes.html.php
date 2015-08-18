<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Manage securities: </title>
		<link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<h1>Securities</h1>
		<nav>
			<ul>
				<li><a href="?addshare">Add share</a></li>
				<li><a href="..">Back..</a></li>
				<li class = "topofpage"><a href="#">Top of page</a></li>
			</ul>
		</nav>
		<?php if(isset($shares)): ?>
			<div id="quotes">
				<table>
					<tr>
						<th>Share</th>
						<th>Acronym</th>
						<th>Exchange</th>
						<th>Company</th>
						<th>Country</th>
						<th>Privileged(Y/N)</th>
						<th>Link</th>
						<th>Indices</th>
						<th>Options</th>
					</tr>
				<?php foreach ($shares as $share): ?>
					<tr class = "<?php
									if($share['active'] == 0){
										echo 'noactive';
									}
									elseif($share['active'] == 1){
										echo 'active';
									}
								?>">
						<td><?php htmlout($share['fullname'].' '); ?></td>
						<td><?php htmlout($share['acronym'].' '); ?></td>
						<td><?php htmlout($share['exchange'].' '); ?></td>
						<td><?php htmlout($share['company'].' '); ?></td>
						<td><?php htmlout($share['country'].' '); ?></td>
						<td><?php if($share['privileged']){htmlout('Y');}else{htmlout('N');} ?></td>
						<td><a href="<?php 
										$link = "http://moex.com/ru/issue.aspx?board=TQBR&code=".trim($share['acronym']);	
										echo $link;
									?>">Info</td>
						<td><?php htmlout($share['indices'].' '); ?></td>
						<td>
							<form action="?" method="post">
								<div>
									<input type="hidden" name="id" value="<?php echo $share['qid']; ?>"></th>
									<input type="submit" name="action" value="Edit">
									<input type="submit" name="action" value="Delete">
								</div>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
		<?php endif; ?>
		<?php include '../logout.inc.html.php'; ?>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.color-2.1.2.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/jquery.scrollTo.min.js"></script>
		<script type="text/javascript" src="../js/common.js"></script>
	</body>
</html>