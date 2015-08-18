	<!DOCTYPE html>
	<html>
		<head>
			<title>Stock Exchanges Management System</title>
			<meta charset="utf-8"/>
			<link href = "css/style.css" rel = "stylesheet" type = "text/css"/>
			<link href = "css/sunny/jquery-ui-1.8.17.custom.css" rel = "stylesheet" type = "text/css"/>
		</head>
		<body>
			<div>
				<h2>Welcome</h2>
			</div>
			<div class="imglogin">
				<a href="#" title="Login">Login</a>
			</div>
			<!--<div id="login">
				<a href="#">Log in</a>
				<form action="">
				  <div>
					<label for="username">Username:</label>
					<input name="username" id="username" type="text" width="145"/>
				  </div>
				  <div>
					<label for="password">Password:</label>
					<input name="password" id="password" type="password" width="145"/>
				  </div>
				  <div>
					<input type="submit" value="Log in!" />
					</div>
				</form>
			</div>-->
			<div id="navigation">
				<div>
					<h3><a href = "#">Content management</a></h3>
					<ul>
						<li id = "exchange"><a href = "exchanges/">Exchanges</a></li>
						<li id = "country"><a href = "countries/">Countries</a></li>
						<li id = "currency"><a href = "currencies/">Currencies</a></li>
						<li id = "company"><a href = "companies/">Companies</a></li>
						<li id = "quote"><a href = "quotes/">Quotes</a></li>
						<li id = "index"><a href = "indices/">Indices</a></li>
						<li id = "rate"><a href = "rates/">Rates</a></li>
					</ul>
				</div>
				<div>
					<h3><a href = "#">Information</a></h3>
					<ul>
						<li><a href = "traders">Leading traders</a></li>
						<li><a href = "working_hours">Current working exchanges worldwide</a></li>
					</ul>
				</div>
				<div>
					<h3><a href = "#">Public section</a></h3>
					<ul>
						<li><a href = "indicators">Indicators</a></li>
						<li><a href = "charts">Charts</a></li>
					</ul>
				</div>
			</div>
			<div id="exchanges">
				<ul>
					<li><a href = "micex.php?ind=1">RTSSTD</a></li>
                    <li><a href = "micex.php?ind=2">MICEX</a></li>
				</ul>
			</div>
			<script src="js/jquery-1.7.1.min.js" type="text/javascript" ></script>
			<script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
			<!--<script type="text/javascript" src="js/jquery-ui/jquery-ui.js"></script>-->
			<script type="text/javascript" src="js/common.js"></script>
		</body>
	</html>