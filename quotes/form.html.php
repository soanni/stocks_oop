<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($pageTitle); ?></title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
	</head>
	<body>
		<h1><?php htmlout($pageTitle); ?></h1>
		<form id="addquote" action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="sharename">Share name: </label> 
				<input type="text" name="sharename" id="sharename" value="<?php htmlout($sharename); ?>">
			</div>
			<div>
				<label for="shortname">Short name: </label> 
				<input type="text" name="shortname" id="shortname" value="<?php htmlout($shortname); ?>">
			</div>
			<div>
				<label for="englishname">English name: </label> 
				<input type="text" name="englishname" id="englishname" value="<?php htmlout($englishname); ?>">
			</div>
			<div>
				<label for="acronym">Acronym: </label> 
				<input type="text" name="acronym" id="acronym" value="<?php htmlout($acronym); ?>">
			</div>
			<div>
				<label for="exchange">Exchange: </label> 
				<select name = "exchange" id="exchange">
					<option value="">Select one</option>
					<?php foreach ($exchanges as $exchange): ?>
						<option value="<?php htmlout($exchange['id']); ?>"
							<?php
								if ($exchange['id'] == $exchangeid){
									echo ' selected';
								}
							?>>
							<?php 
								htmlout($exchange['name']); 
							?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="company">Company: </label> 
				<select name = "company" id="company">
					<option value="">Select one</option>
					<?php foreach ($companies as $company): ?>
						<option value="<?php htmlout($company['id']); ?>"
							<?php
								if ($company['id'] == $companyid){
									echo ' selected';
								}
							?>>
							<?php 
								htmlout($company['name']); 
							?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="country">Country: </label> 
				<select name = "country" id="country">
					<option value="">Select one</option>
					<?php foreach ($countries as $country): ?>
						<option value="<?php htmlout($country['id']); ?>"
							<?php
								if ($country['id'] == $countryid){
									echo ' selected';
								}
							?>>
							<?php 
								htmlout($country['name']); 
							?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="privileged">Privileged: </label> 
				<select name = "privileged" id="privileged">
					<option value="">Select one</option>
					<option value="1"
                        <?php
                            if ($privileged){
                                echo ' selected';
                            }
                        ?>
                        >YES</option>
					<option value="0"
                        <?php
                            if (!$privileged){
                                echo ' selected';
                            }
                        ?>
                        >NO</option>
				</select>
			</div>
            <div id ="indices">
                <span>Indices</span>
                <?php foreach ($indices as $index): ?>
                    <div>
                        <label for="index<?php htmlout($index['id']);?>">
                            <input type="checkbox" name="indices[]" id="index<?php htmlout($index['id']); ?>"
                                   value = "<?php htmlout($index['id']); ?>"
                                <?php
                                if ($index['selected']){
                                    echo ' checked';
                                }
                                ?>
                                ><?php htmlout($index['name']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
			<div>
				<input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" value="<?php htmlout($button); ?>">
			</div>
		</form>
	</body>
</html>