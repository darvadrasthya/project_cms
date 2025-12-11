<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($title) ? $title : 'CMS System'; ?></title>
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
			color: #333;
		}

		.container {
			background: white;
			padding: 60px 40px;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			text-align: center;
			max-width: 600px;
			width: 90%;
		}

		h1 {
			font-size: 2.5em;
			color: #667eea;
			margin-bottom: 20px;
		}

		p {
			font-size: 1.2em;
			color: #666;
			margin-bottom: 30px;
			line-height: 1.6;
		}

		.btn {
			display: inline-block;
			padding: 15px 40px;
			margin: 10px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			text-decoration: none;
			border-radius: 50px;
			font-weight: 600;
			transition: transform 0.3s, box-shadow 0.3s;
		}

		.btn:hover {
			transform: translateY(-3px);
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.5);
		}

		.feature-list {
			margin: 30px 0;
			text-align: left;
		}

		.feature-list li {
			padding: 10px 0;
			border-bottom: 1px solid #eee;
			list-style: none;
			padding-left: 30px;
			position: relative;
		}

		.feature-list li:before {
			content: "✓";
			position: absolute;
			left: 0;
			color: #667eea;
			font-weight: bold;
			font-size: 1.2em;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>🚀 CMS System</h1>
		<p>Selamat datang di Content Management System dengan fitur lengkap untuk mengelola konten website Anda.</p>

		<ul class="feature-list">
			<li>User Management & Role-Based Access Control</li>
			<li>Page & Content Management</li>
			<li>Media Library & File Manager</li>
			<li>Menu Builder System</li>
			<li>Audit Logging & Activity Tracking</li>
			<li>Advanced Security Features</li>
		</ul>

		<div style="margin-top: 40px;">
			<a href="<?php echo base_url('auth/login'); ?>" class="btn">Login</a>
			<a href="<?php echo base_url('about'); ?>" class="btn">About</a>
		</div>
	</div>
</body>

</html>