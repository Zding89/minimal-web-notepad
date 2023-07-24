<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		.center {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 80%;
			max-width: 300px;
			height: 26%;
			margin: 0 auto;
			font-family: sans-serif;
			font-size: large;
			background-color: #f2f2f2;
			padding: 20px;
			border-radius: 5px;
		}

		.center input[type="password"] {
			width: 100%;
			padding: 12px;
			margin: 8px 0;
			box-sizing: border-box;
			border: none;
			background-color: #f2f2f2;
			font-size: 16px;
			border: 1px solid black;
		}

		.center button[type="submit"] {
			width: 100%;
			padding: 12px;
			margin: 8px 0;
			box-sizing: border-box;
			border: none;
			background-color: #337ab7;
			color: white;
			font-size: 16px;
			border-radius: 5px;
		}

		.center p {
			font-size: small;
			text-align: center;
		}

		.center a {
			color: #4CAF50;
			text-decoration: none;
		}

		.center a:hover {
			text-decoration: underline;
		}
	</style>
	<title><?php if (isset($_GET['note'])) print $_GET['note']; ?></title>
</head>
<body onload="document.forms[0].password.focus();">
	<div class="center">
		<form method="POST">
			<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
				无效的密码
			<?php } ?>
			访问密码：</br>
			<input type="password" name="password" autofocus>
			<button type="submit">进入</button>
			<p>此便签有密码<br><a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>">创建一个新的便签</a></p>
			<?php if ($allowReadOnlyView == "1") { ?>
				<p><a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?view"; ?>">只读模式查看</a></p>
			<?php } ?>
		</form>
	</div>
</body>
</html>