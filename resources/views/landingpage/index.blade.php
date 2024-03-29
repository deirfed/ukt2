<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | UKT2.ORG</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/styles.css') }}">
</head>

<body>
    <header class="header">
        <nav class="nav container">
            <a href="#" class="nav_logo">UKT2.ORG</a>
            <div class="nav_toggle" id="nav-toggle"><i class='bx bx-grid-alt'></i></div>
            <div class="nav_menu" id="nav-menu">
                <ul class="nav_list">
                    <li class="nav_item"><a href="#" class="nav_link">Home</a></li>
                    <li class="nav_item"><a href="https://aset.ukt2.org" target="_blank" class="nav_link">Aset</a></li>
                    <li class="nav_item"><a href="https://simoja.ukt2.org" target="_blank" class="nav_link">Simoja</a>
                    </li>
                </ul>
                <div class="nav_close" id="nav-close"><i class='bx bx-x'></i></div>
            </div>
        </nav>
    </header>
    <main class="main">
        <section class="home">
            <div class="home_container container">
                <div class="home_data">
                    <span class="home_subtitle">Halo, Selamat datang di,</span>
                    <h1 class="home_title">UKT2.ORG</h1>
                    <p class="home_description">Sistem Informasi & Administrasi <br> Unit Kerja Teknis 2 Kepulauan
                        Seribu, DKI Jakarta.</p>
                </div>
                <div class="home_img">
                    <img src="{{ asset('assets/img/ukt2logo.png') }}" alt="">
                    <div class="home_shadow"></div>
                </div>
            </div>
            <footer class="home_footer">
                <span>(021) 12345</span>
                <span>|</span>
                <span>info@ukt2.org</span>
            </footer>
        </section>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
            y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice">
            <defs>
                <linearGradient id="bg">
                    <stop offset="0%" style="stop-color:rgba(130, 158, 249, 0.06)"></stop>
                    <stop offset="50%" style="stop-color:rgba(76, 190, 255, 0.6)"></stop>
                    <stop offset="100%" style="stop-color:rgba(6, 84, 143, 0.2)"></stop>
                </linearGradient>
                <path id="wave" fill="url(#bg)"
                    d="M-363.852,502.589c0,0,236.988-41.997,505.475,0s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
            </defs>
            <g>
                <use xlink:href='#wave' opacity=".3">
                    <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="10s"
                        calcMode="spline" values="270 230; -334 180; 270 230" keyTimes="0; .5; 1"
                        keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                </use>
                <use xlink:href='#wave' opacity=".6">
                    <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="8s"
                        calcMode="spline" values="-270 230;243 220;-270 230" keyTimes="0; .6; 1"
                        keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                </use>
                <use xlink:href='#wave' opacty=".9">
                    <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="6s"
                        calcMode="spline" values="0 230;-140 200;0 230" keyTimes="0; .4; 1"
                        keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                </use>
            </g>
        </svg>
    </main>
    <script src="{{ asset('assets/landingpage/js/animate.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/main.js') }}"></script>
</body>

</html>
