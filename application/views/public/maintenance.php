<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode | <?php echo htmlspecialchars($site_name ?? 'Website'); ?></title>
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .bg-animation li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 50%;
        }
        
        .bg-animation li:nth-child(1) { left: 25%; width: 80px; height: 80px; animation-delay: 0s; }
        .bg-animation li:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; }
        .bg-animation li:nth-child(3) { left: 70%; width: 20px; height: 20px; animation-delay: 4s; }
        .bg-animation li:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; }
        .bg-animation li:nth-child(5) { left: 65%; width: 20px; height: 20px; animation-delay: 0s; }
        .bg-animation li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
        .bg-animation li:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
        .bg-animation li:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
        .bg-animation li:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
        .bg-animation li:nth-child(10) { left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; }
        
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 50%;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
        
        .maintenance-container {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 40px;
            max-width: 600px;
        }
        
        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 30px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .maintenance-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .maintenance-message {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .countdown-container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .countdown-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
            margin-bottom: 15px;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .countdown-item {
            text-align: center;
        }
        
        .countdown-value {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px 20px;
            min-width: 80px;
        }
        
        .countdown-unit {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
            opacity: 0.8;
        }
        
        .contact-info {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .contact-info a {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .contact-info a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .progress-bar-container {
            width: 100%;
            height: 6px;
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
            margin-top: 20px;
            overflow: hidden;
        }
        
        .progress-bar-animated {
            height: 100%;
            background: white;
            border-radius: 3px;
            animation: loading 2s ease-in-out infinite;
        }
        
        @keyframes loading {
            0% { width: 0%; margin-left: 0; }
            50% { width: 70%; margin-left: 15%; }
            100% { width: 0%; margin-left: 100%; }
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            opacity: 1;
            transform: translateY(-3px);
        }

        @media (max-width: 576px) {
            .maintenance-title {
                font-size: 1.8rem;
            }
            .maintenance-icon {
                font-size: 60px;
            }
            .countdown-value {
                font-size: 1.8rem;
                padding: 10px 15px;
                min-width: 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <ul class="bg-animation">
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
    </ul>
    
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="bi bi-gear-wide-connected"></i>
        </div>
        
        <h1 class="maintenance-title">
            <?php echo htmlspecialchars($maintenance_title ?? "We'll be back soon!"); ?>
        </h1>
        
        <p class="maintenance-message">
            <?php echo htmlspecialchars($maintenance_message ?? 'We are currently performing scheduled maintenance. Please check back later.'); ?>
        </p>
        
        <div class="progress-bar-container">
            <div class="progress-bar-animated"></div>
        </div>
        
        <?php if(!empty($maintenance_end_time)): ?>
        <div class="countdown-container">
            <div class="countdown-label">Estimated time remaining</div>
            <div class="countdown" id="countdown">
                <div class="countdown-item">
                    <span class="countdown-value" id="days">00</span>
                    <span class="countdown-unit">Days</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="hours">00</span>
                    <span class="countdown-unit">Hours</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="minutes">00</span>
                    <span class="countdown-unit">Minutes</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="seconds">00</span>
                    <span class="countdown-unit">Seconds</span>
                </div>
            </div>
        </div>
        
        <script>
            const endTime = new Date("<?php echo htmlspecialchars($maintenance_end_time); ?>").getTime();
            
            const countdown = setInterval(function() {
                const now = new Date().getTime();
                const distance = endTime - now;
                
                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("countdown").innerHTML = "<p>Maintenance complete! Refreshing...</p>";
                    setTimeout(() => location.reload(), 3000);
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
            }, 1000);
        </script>
        <?php endif; ?>
        
        <?php if(!empty($contact_email)): ?>
        <div class="contact-info">
            <p style="margin-bottom: 15px; opacity: 0.8;">Need urgent assistance?</p>
            <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>">
                <i class="bi bi-envelope"></i>
                Contact Support
            </a>
        </div>
        <?php endif; ?>
        
        <div class="social-links">
            <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
        </div>
    </div>
</body>
</html>
