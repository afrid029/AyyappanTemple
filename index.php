<?php SESSION_START() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="Assets/Images/logo.jpeg" />
    <title>Sri Hariharasudhan Ayyappan Temple</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/CSS/alert.css">
    <link rel="stylesheet" href="/Assets/CSS/liveVideo.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: #fdf6ec;
        }

        .banner-bg-img {
            background-image: url("Assets/Images/dome.jpg");
            background-size: cover;
            background-position: center;
            position: absolute;
            inset: 0;
            opacity: 0.06;
        }

        .logo-circle {
            width: 90px;
            height: 90px;
            background-image: url(Assets/Images/logo.jpeg);
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            border: 5px solid #7f1d1d;
        }

        .eventList::-webkit-scrollbar {
            display: none;
        }

        .noticeList::-webkit-scrollbar {
            display: none;
        }

        input {
            text-transform: none;
        }
    </style>
</head>

<body class="min-h-screen">

    <?php
    if (isset($_SESSION['fromAction']) && $_SESSION['fromAction'] === true) { ?>
        <div class="alert-container" id="alertSecond">
            <div class="alert" id="alertContSecond">
                <p><?php echo $_SESSION['message'] ?></p>
            </div>
        </div>
        <?php
        if ($_SESSION['status'] === true) {
            echo "<script>document.getElementById('alertContSecond').style.backgroundColor = '#1D7524';</script>";
        } else {
            echo "<script>document.getElementById('alertContSecond').style.backgroundColor = '#dbaf20';</script>";
        }
        ?>
        <script>
            document.getElementById('alertSecond').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('alertSecond').style.display = 'none';
            }, 5000);
        </script>
    <?php }
    $_SESSION['fromAction'] = false;
    ?>

    <!-- HEADER / BANNER -->
    <header class="relative bg-red-900 text-white overflow-hidden">
        <div class="banner-bg-img"></div>
        <div class="relative z-10 flex flex-col items-center justify-center py-8 px-4 text-center gap-3">
            <div class="logo-circle mx-auto shadow-lg"></div>
            <h1 class="text-2xl md:text-4xl font-bold tracking-widest uppercase" style="font-family:'Acme',sans-serif;">
                Sri Hariharasudhan Ayyappan Temple
            </h1>
            <p class="text-sm text-red-200 tracking-widest uppercase">Mississauga, Ontario, Canada</p>
        </div>
        <div class="absolute top-4 right-4 z-10">
            <?php if (!isset($_COOKIE['user'])) { ?>
                <button onclick="openLogin()" class="bg-amber-500 hover:bg-amber-400 transition text-white font-semibold px-4 py-2 rounded-lg text-sm shadow">
                    Login
                </button>
            <?php } else { ?>
                <a href="/dashboard" target="_blank" class="bg-amber-500 hover:bg-amber-400 transition text-white font-semibold px-4 py-2 rounded-lg text-sm shadow">
                    Dashboard
                </a>
            <?php } ?>
        </div>
    </header>

    <!-- NAV STRIP -->
    <div class="bg-red-800 text-center text-xs text-red-100 py-1 tracking-widest uppercase">
        Mon–Fri 7AM–1PM &nbsp;|&nbsp; 5PM–9PM &nbsp;|&nbsp; (905) 624-5658
    </div>

    <!-- MAIN CONTENT: LIVE + EVENTS -->
    <main class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Live TV -->
        <section class="flex flex-col gap-3">
            <h2 class="text-center text-red-800 font-bold text-lg uppercase tracking-widest" style="font-family:'Acme',sans-serif;">
                Temple Live
            </h2>
            <div class="rounded-xl overflow-hidden shadow-lg border border-amber-200">
                <?php include('Components/LiveTv.php') ?>
            </div>
        </section>

        <!-- Upcoming Events -->
        <section class="flex flex-col gap-3">
            <h2 class="text-center text-red-800 font-bold text-lg uppercase tracking-widest" style="font-family:'Acme',sans-serif;">
                Upcoming Events
            </h2>
            <div id="event-details" class="eventList bg-red-900 rounded-xl p-3 flex flex-col gap-3 overflow-y-auto" style="min-height:260px; max-height:420px;"></div>
        </section>

    </main>

    <!-- NOTICES SECTION -->
    <section class="relative bg-amber-500 py-12 px-4 mt-4 overflow-hidden">
        <div class="banner-bg-img" style="opacity:0.05;"></div>
        <div class="relative z-10">
            <div class="text-center mb-8">
                <span class="inline-block bg-red-800 text-white text-sm font-bold uppercase tracking-widest px-6 py-2 rounded-full shadow">
                    Notices
                </span>
            </div>
            <div id="notice-details" class="noticeList max-w-7xl mx-auto"></div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="relative bg-red-900 text-white overflow-hidden">
        <div class="banner-bg-img"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-amber-400 font-bold text-lg mb-4 uppercase tracking-widest">We Are</h4>
                <p class="text-sm text-red-100 leading-7">
                    5288 General Rd, Mississauga, ON L4W 1Z8<br>
                    Phone: (905) 624-5658<br>
                    Hours: Mon–Fri 7AM–1PM, 5–9PM<br>
                    <a href="https://www.instagram.com/hariharasudhan_ayyappantemple/" target="_blank" class="text-amber-300 hover:underline">Instagram</a> &nbsp;|&nbsp;
                    <a href="https://www.tiktok.com/@hariharasudhan.ayyappan" target="_blank" class="text-amber-300 hover:underline">TikTok</a> &nbsp;|&nbsp;
                    <a href="https://www.youtube.com/@HariharasudhanAyyappanTemple" target="_blank" class="text-amber-300 hover:underline">YouTube</a>
                </p>
                <p class="text-xs text-red-300 mt-4">Designed by <a href="https://masspro.ca/en/" target="_blank" class="text-white hover:underline font-semibold">Mass Productions IT</a></p>
            </div>
            <div>
                <h4 class="text-amber-400 font-bold text-lg mb-4 uppercase tracking-widest">About Us</h4>
                <p class="text-sm text-red-100 leading-7">
                    The Sri Hariharasudhan Temple is located in Mississauga, Ontario, Canada. Sri Katpaga Vinayagar is the main deity, alongside Sri Konanathar, Sri Mathumaiyamman, Sri Ayyappa Swami, and the Navagrahas among many others.
                </p>
            </div>
        </div>
    </footer>

    <!-- LOGIN MODAL -->
    <?php include('Components/loginModel.php') ?>

    <!-- IMAGE POPUP LIGHTBOX -->
    <div id="img-popup" onclick="closeImagePopup()" style="display:none;"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md p-4 md:p-8">
        <button onclick="closeImagePopup()"
            class="fixed top-2 right-2 text-white/70 hover:text-white text-5xl leading-none font-thin z-[101]">&times;</button>
        <div onclick="event.stopPropagation()" class="relative overflow-y-auto rounded-xl" style="max-height:90vh; width:95vw;">
            <img id="img-popup-img" src="" alt="Notice"
                class="block rounded-xl shadow-2xl"
                style="width:95vw; height:auto;" />
        </div>
    </div>

    <script>
        // Resize live player height to match event list on desktop
        const lPlayer = document.querySelector('.hlsWrapper');
        window.addEventListener('resize', resizeWindow);
        window.addEventListener('load', resizeWindow);

        function resizeWindow() {
            if (window.innerWidth >= 1024 && lPlayer) {
                const h = lPlayer.offsetHeight;
                const el = document.getElementById('event-details');
                if (el && h > 0) el.style.maxHeight = h + 'px';
            }
        }

        function loadEvent() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetAllEventHome.php', true);
            xhr.onload = function() {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("event-details").innerHTML = response.html;
                }
            }
            xhr.send();
        }

        function loadNotices() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetAllNoticesHome.php', true);
            xhr.onload = function() {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('notice-details').innerHTML = response.html;
                }
            }
            xhr.send();
        }

        window.onload = function() {
            loadEvent();
            loadNotices();
        }

        function openLogin() {
            document.getElementById('login-model').style.display = 'flex';
        }

        function closeLoginViewer() {
            document.getElementById('login-model').style.display = 'none';
        }

        function openImagePopup(src) {
            document.getElementById('img-popup-img').src = src;
            document.getElementById('img-popup').style.display = 'flex';
        }

        function closeImagePopup() {
            document.getElementById('img-popup').style.display = 'none';
            document.getElementById('img-popup-img').src = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImagePopup();
        });
    </script>
</body>

</html>