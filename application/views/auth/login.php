<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($title) ? $title : 'Login'; ?> - CMS System</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 20px;
		}

		.login-container {
			background: white;
			padding: 40px;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			width: 100%;
			max-width: 450px;
		}

		.login-header {
			text-align: center;
			margin-bottom: 30px;
		}

		.login-header h1 {
			font-size: 2em;
			color: #667eea;
			margin-bottom: 10px;
		}

		.login-header p {
			color: #666;
			font-size: 0.95em;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			color: #333;
			font-weight: 600;
			font-size: 0.95em;
		}

		.form-group input {
			width: 100%;
			padding: 12px 15px;
			border: 2px solid #e0e0e0;
			border-radius: 8px;
			font-size: 1em;
			transition: border-color 0.3s;
		}

		.form-group input:focus {
			outline: none;
			border-color: #667eea;
		}

		.form-check {
			display: flex;
			align-items: center;
			margin-bottom: 20px;
		}

		.form-check input[type="checkbox"] {
			width: auto;
			margin-right: 8px;
		}

		.form-check label {
			color: #666;
			font-size: 0.9em;
			margin: 0;
		}

		.btn-login {
			width: 100%;
			padding: 14px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 1em;
			font-weight: 600;
			cursor: pointer;
			transition: transform 0.3s, box-shadow 0.3s;
		}

		.btn-login:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
		}

		.btn-login:active {
			transform: translateY(0);
		}

		.alert {
			padding: 12px 15px;
			border-radius: 8px;
			margin-bottom: 20px;
			font-size: 0.9em;
		}

		.alert-danger {
			background: #fee;
			color: #c33;
			border: 1px solid #fcc;
		}

		.alert-success {
			background: #efe;
			color: #3c3;
			border: 1px solid #cfc;
		}

		.links {
			text-align: center;
			margin-top: 20px;
			padding-top: 20px;
			border-top: 1px solid #e0e0e0;
		}

		.links a {
			color: #667eea;
			text-decoration: none;
			font-size: 0.9em;
			transition: color 0.3s;
		}

		.links a:hover {
			color: #764ba2;
			text-decoration: underline;
		}

		.divider {
			margin: 0 10px;
			color: #ccc;
		}

		@media (max-width: 480px) {
			.login-container {
				padding: 30px 20px;
			}

			.login-header h1 {
				font-size: 1.5em;
			}
		}
	</style>
</head>

<body>
	<div class="login-container">
		<div class="login-header">
			<h1>🔐 Login</h1>
			<p><?php echo isset($subtitle) ? $subtitle : 'Sign in to your account'; ?></p>
		</div>

		<?php if ($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('success')) : ?>
			<div class="alert alert-success">
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		<?php endif; ?>

		<form action="<?php echo base_url('auth/do-login'); ?>" method="post">
			<div class="form-group">
				<label for="login">Email or Username</label>
				<input type="text" id="login" name="login" placeholder="Enter your email or username" required autofocus>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" placeholder="Enter your password" required>
			</div>

			<div class="form-check">
				<input type="checkbox" id="remember" name="remember" value="1">
				<label for="remember">Remember me</label>
			</div>

			<button type="submit" class="btn-login">Sign In</button>
		</form>

		<div class="links">
			<a href="<?php echo base_url('auth/forgot-password'); ?>">Forgot Password?</a>
			<span class="divider">|</span>
			<a href="<?php echo base_url(); ?>">Back to Home</a>
		</div>
	</div>
</body>

</html>