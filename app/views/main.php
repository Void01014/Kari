<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Kari/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Listings</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #22d3ee;
            min-height: 100vh;
        }

        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: rotate 20s infinite linear;
        }

        .shape.circle {
            border-radius: 50%;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg) translateX(10px);
            }

            100% {
                transform: rotate(360deg) translateX(10px);
            }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: pulse 8s infinite ease-in-out;
            will-change: transform;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.5;
            }
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .upload-area {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
    </style>
</head>

<body class="font-mono flex flex-col items-center h-[100vh]">
    <div class="background-container" id="bg">
        <div class="orb" style="width: 300px; height: 300px; background: #ffffffff; top: 10%; left: 20%;"></div>
        <div class="orb" style="width: 400px; height: 400px; background: #ffffffff; bottom: 10%; right: 10%;"></div>
        <div class="orb" style="width: 250px; height: 250px; background: #ffffffff; top: 50%; right: 30%;"></div>
    </div>

    <script>
        const bg = document.getElementById('bg');
        for (let i = 0; i < 10; i++) {
            const shape = document.createElement('div');
            shape.className = 'shape' + (Math.random() > 0.5 ? ' circle' : '');
            const size = Math.random() * 100 + 50;
            shape.style.width = size + 'px';
            shape.style.height = size + 'px';
            shape.style.left = Math.random() * 100 + '%';
            shape.style.top = Math.random() * 100 + '%';
            shape.style.animationDuration = (Math.random() * 20 + 15) + 's';
            bg.appendChild(shape);
        }
    </script>

    <?php
        include __DIR__ . "/partials/navbar.php";
    ?>
    <?php echo $content; ?>
    <?php if (isset($_SESSION['success_user_registration'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Good Job',
                text: 'Your account was created successfully'
            });
        </script>
        <?php unset($_SESSION['success_user_registration']); ?>
        <?php endif; ?>
        <?php if(isset($_SESSION['success_listing_registration'])): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job',
                    text: 'Your Listing was created successfully'
                });
            </script>
            <?php unset($_SESSION['success_listing_registration']); ?>
        <?php endif; ?>
</body>
    <?php $url = $_GET['url'] ?? 'home' ?> 
    <?php if($url == "signUp"): ?>
        <script src="/Kari/public/js/signUp.js"></script>
    <?php elseif($url == "signIn"): ?>
        <script src="/Kari/public/js/signIn.js"></script>
    <?php elseif($url == "allListings"): ?>
        <script src="/Kari/public/js/listings.js"></script>
    <?php endif; ?>
</html>