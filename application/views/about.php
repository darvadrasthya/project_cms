<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($title) ? $title : 'About - CMS System'; ?></title>
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
			padding: 40px 20px;
			color: #333;
		}

		.container {
			background: white;
			padding: 40px;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			max-width: 800px;
			margin: 0 auto;
		}

		h1 {
			font-size: 2.5em;
			color: #667eea;
			margin-bottom: 20px;
		}

		h2 {
			font-size: 1.8em;
			color: #764ba2;
			margin-top: 30px;
			margin-bottom: 15px;
		}

		p {
			font-size: 1.1em;
			color: #666;
			line-height: 1.8;
			margin-bottom: 20px;
		}

		.btn {
			display: inline-block;
			padding: 12px 30px;
			margin-top: 20px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			text-decoration: none;
			border-radius: 50px;
			font-weight: 600;
			transition: transform 0.3s;
		}

		.btn:hover {
			transform: translateY(-3px);
		}

		.tech-stack {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			margin: 20px 0;
		}

		.tech-item {
			background: #f8f9fa;
			padding: 20px;
			border-radius: 10px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>📖 About CMS System</h1>

		<p>
			CMS System adalah aplikasi Content Management System yang dibangun dengan CodeIgniter 3
			dan dirancang untuk memberikan kemudahan dalam mengelola konten website secara profesional.
		</p>

		<h2>🎯 Fitur Utama</h2>
		<p>
			Sistem ini dilengkapi dengan berbagai fitur seperti manajemen user berbasis role,
			manajemen halaman dan konten, media library, menu builder, serta sistem audit logging
			yang komprehensif untuk tracking semua aktivitas.
		</p>

		<h2>🔐 Keamanan</h2>
		<p>
			Menggunakan password hashing SHA-256 dengan unique salt, session management,
			rate limiting, login attempt tracking, dan IP logging untuk keamanan maksimal.
		</p>

		<h2>💻 Technology Stack</h2>
		<div class="tech-stack">
			<div class="tech-item">
				<strong>Framework</strong><br>CodeIgniter 3.x
			</div>
			<div class="tech-item">
				<strong>Database</strong><br>MySQL
			</div>
			<div class="tech-item">
				<strong>Security</strong><br>SHA-256 + Salt
			</div>
			<div class="tech-item">
				<strong>Architecture</strong><br>MVC Pattern
			</div>
		</div>

		<div style="text-align: center;">
			<a href="<?php echo base_url(); ?>" class="btn">← Back to Home</a>
		</div>
	</div>
</body>

</html>