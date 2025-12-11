<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 15px;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .register-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        .register-body {
            padding: 40px;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-floating .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            height: 55px;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .form-floating label {
            padding: 1rem 1rem;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .register-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #f0f0f0;
            background: #f8f9fa;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .password-requirements li {
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1><i class="bi bi-person-plus me-2"></i>Create Account</h1>
                <p>Join us today</p>
            </div>

            <div class="register-body">
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo base_url('auth/do-register'); ?>" method="post">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>" required>
                        <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                    </div>

                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" required>
                        <label for="email"><i class="bi bi-envelope me-2"></i>Email Address</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password" required>
                        <label for="password_confirm"><i class="bi bi-lock-fill me-2"></i>Confirm Password</label>
                    </div>

                    <ul class="password-requirements">
                        <li>At least 8 characters long</li>
                        <li>Contains a mix of letters and numbers</li>
                    </ul>

                    <button type="submit" class="btn btn-register mt-3">
                        <i class="bi bi-person-plus me-2"></i>Create Account
                    </button>
                </form>
            </div>

            <div class="register-footer">
                <p class="mb-0">Already have an account? <a href="<?php echo base_url('auth/login'); ?>">Sign in</a></p>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo base_url(); ?>" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to Homepage
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>