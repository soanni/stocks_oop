<?php
	include_once 'helpers/helpers.inc.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tab.php</title>
	</head>
	<body>
		<table id="lastrates">
			<tr>
				<th>Rate date</th>
				<th>Name</th>
				<th>Abbr</th>
				<th>Close rate</th>
				<th>%</th>
			</tr>
			<?php foreach ($result as $r): ?>
				<tr>
					<td><?php htmlout($r['ratedate'].' '); ?></td>
					<td><?php htmlout($r['fullname'].' '); ?></td>
					<td><?php htmlout($r['acronym'].' '); ?></td>
					<td><?php htmlout($r['closerate'].' '); ?></td>
					<td><?php htmlout($r['percent'].'%'); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</body>
</html>