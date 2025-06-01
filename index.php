<?php SESSION_START() ?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="Assets/Images/logo.jpeg" />
    <title> Sri Hariharasudhan Ayyappan Temple</title>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Acme&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/index.css">
    <link rel="stylesheet" href="/Assets/CSS/model.css">
    <link rel="stylesheet" href="/Assets/CSS/login.css">
    <link rel="stylesheet" href="/Assets/CSS/alert.css">

</head>

<body>
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
    <?php
    }
    $_SESSION['fromAction'] = false;

?>
    <div class="banner">
        <div class="banner-bg"></div>
        <div class="banner-content">
            <div class="banner-title">
             Sri Hariharasudhan Ayyappan Temple
            </div>
            <div class="banner-logo">
                <div class="banner-img"></div>
            </div>

           
              <?php if(!isset($_COOKIE['user'])) { ?>
            <li class="login" onclick="openLogin()">
                    
                    Login</li>

            <?php   } else {
                ?>
                <li  class="login">
              
                <a style="color:white;" href="/dashboard" target="_blank">Dashboard</a></li>
                
                <?php
            }?>

        </div>

        
    </div>
    <div class="content">
        <div class="liveContent">
            <div class="liveTitle">SRI HARIHARASUDHAN TEMPLE LIVE</div>
            <div class="livePlayer" >
                 <?php include('Components/LiveTv.php') ?>
            </div>
        </div>
        <div class="eventContent">
            <div class="eventTitle">SRI HARIHARASUDHAN TEMPLE UPCOMING EVENTS</div>
            <div id="event-details" class="eventList">
               
                
            </div>
        </div>
    </div>
    <footer class="footer-body">
        <div class="banner-bg"></div>
        <div class="footer">
        <div class="contact">
            <h4>We Are</h4>
            <div>5288 GENERAL RD, MISSISSAUGA, ON LA4W 1Z8</div>
            <div>PHONE: (905) 624-5658</div>
            <div>hOURS : MON-FRI 7A.M - 1P.M, 5-9P.M</div>
            <div>IG : <a style="text-decoration: none; color: orange" href="https://www.instagram.com/hariharasudhan_ayyappantemple/" target="_blank">hariharasudhan_ayyappantemple</a></div>
            <div>TikTok : <a style="text-decoration: none; color: orange" href="https://www.tiktok.com/@hariharasudhan.ayyappan" target="_blank">hariharasudhan.ayyappan</a></div>
            <div>YouTube : <a style="text-decoration: none; color: orange" href="https://www.youtube.com/@HariharasudhanAyyappanTemple" target="_blank">Sri Hariharasudhan Ayyappan Temple</a></div>
            <div style="color: white; font-weight: 700">Designed By : <a style="color: white; text-decoration: none;" href="https://masspro.ca/en/" target="_blank">Mass Productions IT</a> </div>

        </div>
        <div class="about">
            <h4>About Us</h4>
            <div>
                The Sri harihara suthan Temple is located in Brampton (Mississauga), Ontario, Canada. Sri Katpaga
                Vinayagar is the main deity. The other deities in the temple include Sri Konanathar, Sri Mathumaiyamman,
                Sri Aancha Neyar Swami, Sri Nagapooshani Ambal, Sri Devi, Sri Mahavishnu(Vishnu), Sri Poomi Devi, Hari
                Hara Buthra Iyanar, Tadsanamoorthy, Sri Raja Rajeswary, Sri Valli, Sri Subramaniyar (Muruan), Sri
                Theivanai, Durkka, Nadarajar (Load Siva), Sri Aiyappa Swami, Navagrahas { 9 Planets – Sun(Surya),
                Moon(Chandra), Mars(Mangala), Mercury(Budha), Jupiter(Brihaspathi), Venus(Sukra), Saturn(Sani), Rahu and
                Ketu } and the Sri Kaala Vairavar.
            </div>

        </div>
    </div>
</footer>

 <?php include('Components/loginModel.php') ?>
</body>

</html>

<script>
    const lPlayer = document.querySelector('.livePlayer');
    window.addEventListener('resize', resizeWindow);
    window.addEventListener('load', resizeWindow);
    video.addEventListener('loadedmetadata', () => {
        console.log(lPlayer.offsetHeight); 
    })

    function resizeWindow() {
        if(window.innerWidth > 1024 || window.orientation == 'landscape'){
            document.querySelector('.eventList').style.height = lPlayer.offsetHeight + 'px';
        }
    }


    function loadEvent() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllEventHome.php', true);
        xhr.onload = function() {
            // console.log("sdsadsad");
            if (xhr.status == 200 && xhr.readyState == 4) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("event-details").innerHTML = response.html;
            }
        }
        xhr.send();
    }

    window.onload = function() {
        loadEvent();
    }

    // console.log(document.querySelector('.banner').offsetHeight + document.querySelector('.footer-body').offsetHeight + document.querySelector('.content').offsetHeight);
    
    function openLogin() {
        // document.getElementById('frontImg').src = posters[currentIndex];
        // closeMobileMenu();
        document.getElementById('login-model').style.display = 'block';
    }

    function closeLoginViewer() {
        document.getElementById('login-model').style.display = 'none';
    }
    
    

    
</script>