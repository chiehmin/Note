<html>
	<head>
		<title>Login Page</title>
	</head>
	<body>
		<?=validation_errors()?>
		<?=form_open('portal/login')?>
			Account: <input type="text" name="name" />
			Password: <input type="password" name="pwd" />
			<input type="submit" value="Login" />
		</form>
	</body>
</html>
