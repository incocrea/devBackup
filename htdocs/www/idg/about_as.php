<?php include( 'configuracion.php' );?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>IDG Windtech</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Startbox">
    <meta name="author" content="RunWebRun">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- Favicon-->
    <link rel="icon" type="image/png" href="assets/img/root/log.png"><!-- Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap"><!-- Style-->
    <!-- build:css -->
    <link rel="stylesheet" href="assets/vendors/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/vendors/css/swiper-bundle.css">
    <link rel="stylesheet" href="assets/css/main.css"><!-- endbuild -->
    <!-- jQuery-->
    <script src="assets/vendors/js/jquery.min.js"></script>
</head>

<body class=" has-topbar">
    <!-- Header-->
    <!-- Navbar top-->
	<nav class="navbar navbar-expand-lg navbar-top  navbar-dark navbar-border-bottom navbar-fixed">
        <div class="container"><a class="navbar-brand" href="index.php"><img src="assets/img/Logo-proyecto.png" width="" height="80" alt=""/>
                <!--<svg xmlns="http://www.w3.org/2000/svg" width="124" height="30" fill="none" class="dark"> 
                    <path fill="#fff" d="M41.155 11.638c-.057-.573-.3-1.018-.732-1.335-.43-.318-1.015-.476-1.754-.476-.502 0-.926.07-1.271.213-.346.137-.611.329-.796.575-.18.246-.27.526-.27.838-.01.26.045.488.164.682.123.194.29.362.504.504.213.138.46.258.739.362.279.1.577.185.895.256l1.306.313a9.21 9.21 0 0 1 1.748.568c.53.236.99.528 1.377.873.389.346.69.753.902 1.222.218.469.33 1.006.334 1.612-.005.89-.232 1.662-.682 2.316-.445.648-1.089 1.152-1.931 1.512-.839.355-1.85.533-3.033.533-1.174 0-2.197-.18-3.068-.54-.867-.36-1.544-.892-2.032-1.598-.483-.71-.736-1.588-.76-2.635h2.976c.033.488.173.895.42 1.222a2.33 2.33 0 0 0 1 .731c.422.161.898.242 1.428.242.521 0 .973-.076 1.357-.227.388-.152.689-.363.902-.633.213-.27.32-.58.32-.93 0-.327-.098-.601-.292-.824-.19-.222-.468-.412-.838-.568a8.524 8.524 0 0 0-1.342-.426l-1.584-.398c-1.226-.298-2.195-.764-2.905-1.399s-1.063-1.49-1.058-2.564c-.005-.88.23-1.65.703-2.308.478-.658 1.134-1.172 1.967-1.541.834-.37 1.78-.554 2.841-.554 1.08 0 2.022.184 2.827.554.81.369 1.44.883 1.89 1.54.45.659.681 1.421.695 2.288h-2.947Zm10.96-.547v2.273h-6.57V11.09h6.57Zm-5.078-2.614h3.026v10.17c0 .28.042.498.128.654a.704.704 0 0 0 .355.32c.156.061.336.092.54.092.142 0 .284-.012.426-.035.142-.029.25-.05.326-.064l.476 2.251a8.515 8.515 0 0 1-.639.163 5.126 5.126 0 0 1-1.001.121c-.73.029-1.369-.069-1.918-.291a2.677 2.677 0 0 1-1.271-1.037c-.303-.469-.452-1.06-.448-1.776V8.478Zm10.16 13.729c-.696 0-1.316-.12-1.86-.362a2.996 2.996 0 0 1-1.293-1.087c-.313-.483-.47-1.084-.47-1.804 0-.606.112-1.115.335-1.527.222-.412.525-.743.909-.994.383-.251.819-.44 1.307-.568a9.96 9.96 0 0 1 1.548-.27 39.213 39.213 0 0 0 1.534-.185c.388-.062.67-.151.845-.27.175-.118.263-.293.263-.525v-.043c0-.45-.142-.798-.426-1.044-.28-.246-.677-.37-1.193-.37-.545 0-.978.121-1.3.363a1.666 1.666 0 0 0-.64.895l-2.797-.227a3.802 3.802 0 0 1 .837-1.72c.417-.487.955-.861 1.613-1.121.663-.266 1.43-.398 2.3-.398.607 0 1.187.07 1.74.213a4.554 4.554 0 0 1 1.485.66 3.21 3.21 0 0 1 1.03 1.151c.251.464.377 1.02.377 1.669V22h-2.87v-1.513h-.085a3.08 3.08 0 0 1-.703.902 3.255 3.255 0 0 1-1.058.604c-.412.142-.888.213-1.428.213Zm.867-2.088c.445 0 .838-.088 1.178-.263.342-.18.609-.421.803-.724.194-.303.291-.647.291-1.03v-1.158a1.62 1.62 0 0 1-.39.17 7.096 7.096 0 0 1-.547.136 27.1 27.1 0 0 1-.611.106l-.554.078a3.746 3.746 0 0 0-.93.249 1.488 1.488 0 0 0-.618.462c-.147.189-.22.426-.22.71 0 .412.149.727.447.944.303.213.687.32 1.15.32ZM65.688 22V11.09h2.933v1.904h.114c.199-.677.532-1.188 1.001-1.534a2.632 2.632 0 0 1 1.62-.525 4.56 4.56 0 0 1 .951.106v2.685a3.95 3.95 0 0 0-.59-.114 5.304 5.304 0 0 0-.688-.05 2.42 2.42 0 0 0-1.193.292c-.346.19-.62.454-.824.795a2.297 2.297 0 0 0-.299 1.18V22h-3.025ZM80.22 11.09v2.274h-6.57V11.09h6.57Zm-5.078-2.613h3.025v10.17c0 .28.043.498.128.654a.704.704 0 0 0 .355.32c.157.061.337.092.54.092.142 0 .284-.012.426-.035.142-.029.251-.05.327-.064l.476 2.251a8.502 8.502 0 0 1-.64.163 5.124 5.124 0 0 1-1 .121c-.73.029-1.37-.069-1.918-.291a2.676 2.676 0 0 1-1.272-1.037c-.303-.469-.452-1.06-.447-1.776V8.478ZM82.483 22V7.455h3.025v5.468h.093c.132-.293.324-.592.575-.895.256-.307.587-.563.995-.767.411-.208.923-.312 1.533-.312a4.1 4.1 0 0 1 2.202.625c.673.412 1.21 1.034 1.612 1.868.403.828.604 1.868.604 3.118 0 1.216-.196 2.244-.59 3.082-.388.833-.918 1.466-1.59 1.896a4.084 4.084 0 0 1-2.245.64c-.587 0-1.086-.098-1.498-.292a3.101 3.101 0 0 1-1.002-.731 3.713 3.713 0 0 1-.596-.902h-.135V22h-2.983Zm2.962-5.454c0 .648.09 1.214.27 1.697.18.483.44.86.78 1.13.342.264.756.397 1.244.397.492 0 .909-.135 1.25-.405.34-.275.599-.653.774-1.136.18-.488.27-1.05.27-1.683 0-.63-.088-1.184-.263-1.662-.175-.479-.433-.853-.774-1.123s-.76-.404-1.257-.404c-.493 0-.91.13-1.25.39-.337.26-.595.63-.775 1.108-.18.478-.27 1.042-.27 1.69Zm14.625 5.667c-1.103 0-2.057-.234-2.862-.703a4.812 4.812 0 0 1-1.854-1.975c-.436-.847-.653-1.83-.653-2.947 0-1.127.217-2.112.653-2.955a4.756 4.756 0 0 1 1.854-1.974c.805-.473 1.759-.71 2.862-.71 1.103 0 2.055.237 2.855.71a4.743 4.743 0 0 1 1.861 1.974c.435.843.653 1.828.653 2.955 0 1.117-.218 2.1-.653 2.947a4.8 4.8 0 0 1-1.861 1.975c-.8.469-1.752.703-2.855.703Zm.014-2.344c.502 0 .921-.142 1.257-.426.336-.289.59-.682.76-1.179.175-.497.263-1.063.263-1.697 0-.635-.088-1.2-.263-1.698-.17-.497-.424-.89-.76-1.179-.336-.288-.755-.433-1.257-.433-.507 0-.933.145-1.278.433-.341.29-.6.682-.774 1.18-.17.497-.256 1.062-.256 1.697 0 .634.085 1.2.256 1.697.175.497.433.89.774 1.18.345.283.772.425 1.278.425Zm9.46-8.778 2.003 3.814 2.053-3.814h3.103l-3.16 5.455L116.789 22h-3.09l-2.152-3.771L109.431 22h-3.125l3.238-5.454-3.125-5.455h3.125Zm10.725 11.094c-.469 0-.871-.166-1.208-.497a1.66 1.66 0 0 1-.497-1.208c0-.464.166-.862.497-1.193a1.661 1.661 0 0 1 1.208-.497c.454 0 .852.166 1.193.497.341.331.511.73.511 1.193 0 .313-.08.6-.241.86a1.832 1.832 0 0 1-.618.617 1.627 1.627 0 0 1-.845.228Z" />
                    <path fill="#F01F4B" d="M19 15a9 9 0 1 1-18 0l.252.099C6.919 17.317 12.439 11.576 10 6a9 9 0 0 1 9 9Z" />
                    <circle cx="4" cy="9" r="4" fill="#FFBB38" />
                </svg>-->
                
                <!--<svg xmlns="http://www.w3.org/2000/svg" width="124" height="31" fill="none" class="light">
                    <path fill="#17161A" d="M41.155 12.475h2.947c-.042-2.593-2.173-4.382-5.412-4.382-3.189 0-5.525 1.761-5.511 4.403-.007 2.145 1.506 3.374 3.963 3.963l1.584.398c1.584.383 2.464.838 2.471 1.818-.007 1.065-1.015 1.79-2.578 1.79-1.598 0-2.748-.739-2.848-2.195h-2.976c.079 3.146 2.33 4.773 5.86 4.773 3.551 0 5.639-1.698 5.646-4.36-.007-2.423-1.832-3.708-4.36-4.277l-1.308-.312c-1.264-.291-2.322-.76-2.3-1.804 0-.938.83-1.626 2.336-1.626 1.47 0 2.372.667 2.486 1.81Zm10.96-.547h-2.052V9.314h-3.026v2.614h-1.491V14.2h1.491v5.681c-.014 2.138 1.442 3.196 3.637 3.104a5.886 5.886 0 0 0 1.64-.284l-.476-2.251c-.149.028-.468.099-.752.099-.604 0-1.023-.227-1.023-1.065V14.2h2.052v-2.273Zm5.082 11.115c1.612 0 2.656-.703 3.189-1.719h.085v1.513h2.87v-7.358c0-2.6-2.202-3.693-4.631-3.693-2.614 0-4.333 1.25-4.752 3.238l2.799.228c.206-.725.852-1.257 1.939-1.257 1.03 0 1.619.518 1.619 1.413v.043c0 .703-.746.795-2.642.98-2.16.198-4.098.923-4.098 3.359 0 2.16 1.541 3.253 3.622 3.253Zm.867-2.088c-.93 0-1.598-.433-1.598-1.264 0-.853.703-1.272 1.768-1.42.66-.093 1.74-.25 2.102-.49v1.157c0 1.143-.944 2.017-2.272 2.017Zm7.624 1.882h3.025v-6.172c0-1.342.98-2.266 2.316-2.266.419 0 .994.071 1.278.164v-2.685a4.542 4.542 0 0 0-.951-.106c-1.222 0-2.224.71-2.621 2.06h-.114v-1.904h-2.933v10.909Zm14.533-10.91h-2.053V9.315h-3.025v2.614H73.65V14.2h1.492v5.681c-.014 2.138 1.442 3.196 3.636 3.104a5.885 5.885 0 0 0 1.64-.284l-.475-2.251c-.15.028-.469.099-.753.099-.604 0-1.023-.227-1.023-1.065V14.2h2.053v-2.273Zm2.262 10.91h2.983V21.09h.135c.419.909 1.335 1.925 3.096 1.925 2.486 0 4.425-1.968 4.425-5.618 0-3.75-2.024-5.611-4.418-5.611-1.825 0-2.698 1.086-3.103 1.974h-.093V8.291h-3.025v14.546Zm2.962-5.455c0-1.946.824-3.189 2.294-3.189 1.498 0 2.294 1.3 2.294 3.19 0 1.903-.81 3.224-2.294 3.224-1.456 0-2.294-1.279-2.294-3.225Zm14.625 5.668c3.31 0 5.369-2.266 5.369-5.625 0-3.38-2.059-5.64-5.369-5.64-3.31 0-5.37 2.26-5.37 5.64 0 3.36 2.06 5.625 5.37 5.625Zm.014-2.344c-1.527 0-2.308-1.399-2.308-3.302 0-1.904.781-3.31 2.308-3.31 1.499 0 2.28 1.406 2.28 3.31 0 1.903-.781 3.302-2.28 3.302Zm9.441-8.778H106.4l3.125 5.454-3.239 5.455h3.125l2.117-3.771 2.152 3.77h3.089l-3.246-5.454 3.161-5.454h-3.104l-2.052 3.814-2.003-3.814Zm10.724 11.094c.909 0 1.698-.76 1.705-1.705-.007-.93-.796-1.69-1.705-1.69-.937 0-1.711.76-1.704 1.69a1.7 1.7 0 0 0 1.704 1.705Z" />
                    <path fill="#F01F4B" d="M19 15.837a9 9 0 1 1-18 0l.252.099c5.667 2.218 11.187-3.524 8.748-9.1a9 9 0 0 1 9 9Z" />
                    <circle cx="4" cy="9.837" r="4" fill="#FFBB38" />
                </svg>--></a><a class="navbar-toggle order-4 popup-inline" href="#navbar-mobile-style-1"><span></span><span></span><span></span></a>
            <ul class="nav navbar-nav order-2 ms-auto nav-no-opacity">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $lang['Idioma_activo'] ?><svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" fill="none">
                            <path fill="currentColor" d="m5 5-.495.495L5 5.99l.495-.495L5 5ZM.505 1.495l4 4 .99-.99-4-4-.99.99Zm4.99 4 4-4-.99-.99-4 4 .99.99Z" />
                        </svg></a>
                    <ul class="dropdown-menu rounded-2 shadow">
                        <li class="nav-item"><a class="nav-link active" href="about_as.php?lang=en"><?php echo $lang['en'] ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="about_as.php?lang=es"><?php echo $lang['es'] ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="about_as.php?lang=po"><?php echo $lang['po'] ?></a></li>
                    </ul>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="index.php"><span><?php echo $lang['Home'] ?></span></a>
                    <!--
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="home-01.html"><span>Home 01</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="home-02.html"><span>Home 02</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="home-03.html"><span>Home 03</span></a></li>
                            <li class="nav-item active"><a class="nav-link" href="home-04.html"><span>Home 04</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="home-05.html"><span>Home 05</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="home-06.html"><span>Home 06</span></a></li>
                        </ul>
                    </div>-->
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="about_as.php"><span><?php echo $lang['About'] ?></span></a>
                    <!--
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="services-01.html"><span>Services 01</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="services-02.html"><span>Services 02</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="service-single.html"><span>Service Single</span></a></li>
                        </ul>
                    </div>
                    -->
                </li>
                <li class="nav-item navbar-dropdown"><a href="app/login.html" target="_blank" class="nav-link"><span><?php echo $lang['Customers'] ?></span></a>
                    <!--
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="about-us.html"><span>About Us</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="about-me.html"><span>About Me</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="pricing.html"><span>Pricing</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="team.html"><span>Team</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="404.html"><span>Page 404</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="coming-soon.html"><span>Coming Soon</span></a></li>
                        </ul>
                    </div>
                    -->
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="services.php"><span><?php echo $lang['Services'] ?></span></a>
                    <!--
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="projects-01.html"><span>Projects 01</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="projects-02.html"><span>Projects 02</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="projects-03.html"><span>Projects 03</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="projects-04.html"><span>Projects 04</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="projects-05.html"><span>Projects 05</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="project-single-01.html"><span>Project Single 01</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="project-single-02.html"><span>Project Single 02</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="project-single-03.html"><span>Project Single 03</span></a></li>
                        </ul>
                    </div>
                    -->
                </li>                
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="contact.php"><span><?php echo $lang['Contact'] ?></span></a>
                    <!--
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="contact-01.html"><span>Contact 01</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="contact-02.html"><span>Contact 02</span></a></li>
                        </ul>
                    </div>
                -->
                </li>
            </ul><!-- Socials-->
            <ul class="nav nav-gap-sm navbar-nav nav-social ms-auto ms-lg-70 me-30 me-lg-0 order-2 order-lg-3 align-items-center">

                <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/profile.php?id=100095142120302" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="14" fill="none">

                            <path fill="currentColor" d="M5.535 2.71h1.053V.748A12.741 12.741 0 0 0 5.055.66c-1.518 0-2.557 1.023-2.557 2.903v1.73H.823v2.195h1.675v5.525h2.053V7.488h1.607l.255-2.195H4.551V3.78c0-.635.159-1.07.984-1.07Z" />

                        </svg></a></li>

                <li class="nav-item"><a class="nav-link" href="https://www.youtube.com/@IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" fill="none">

                            <path fill="currentColor" d="M15.048 2.23A1.87 1.87 0 0 0 13.737.9C12.58.587 7.94.587 7.94.587S3.301.587 2.144.9A1.87 1.87 0 0 0 .832 2.23c-.31 1.172-.31 3.618-.31 3.618s0 2.445.31 3.617c.171.647.674 1.135 1.312 1.308 1.157.314 5.796.314 5.796.314s4.64 0 5.797-.314a1.842 1.842 0 0 0 1.311-1.308c.31-1.172.31-3.617.31-3.617s0-2.446-.31-3.618ZM6.423 8.068v-4.44l3.877 2.22-3.877 2.22Z" />

                        </svg></a></li>

                <li class="nav-item"><a class="nav-link" href="https://twitter.com/IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" fill="none">

                            <path fill="currentColor" d="M12.854 2.986c.009.124.009.248.009.373 0 3.793-2.887 8.163-8.164 8.163a8.108 8.108 0 0 1-4.406-1.288c.23.027.453.036.693.036a5.746 5.746 0 0 0 3.562-1.226 2.874 2.874 0 0 1-2.683-1.99 3.035 3.035 0 0 0 1.297-.053 2.87 2.87 0 0 1-2.3-2.816v-.036a2.89 2.89 0 0 0 1.296.365A2.867 2.867 0 0 1 .88 2.124c0-.533.142-1.022.391-1.448a8.156 8.156 0 0 0 5.916 3.002 3.239 3.239 0 0 1-.07-.657c0-1.581 1.278-2.87 2.869-2.87.826 0 1.572.347 2.096.907a5.65 5.65 0 0 0 1.821-.693 2.862 2.862 0 0 1-1.261 1.581 5.751 5.751 0 0 0 1.652-.444 6.169 6.169 0 0 1-1.44 1.484Z" />

                        </svg></a></li>

                <li class="nav-item"><a href="https://www.instagram.com/idgwindtech/" target="_blank" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" fill="none">

                            <path fill="currentColor" d="M7.004 3.692c-1.754 0-3.169 1.403-3.169 3.142 0 1.74 1.415 3.142 3.169 3.142 1.753 0 3.168-1.403 3.168-3.142 0-1.739-1.415-3.142-3.168-3.142Zm0 5.185a2.055 2.055 0 0 1-2.06-2.043c0-1.126.924-2.042 2.06-2.042 1.136 0 2.06.916 2.06 2.042a2.055 2.055 0 0 1-2.06 2.043Zm4.036-5.313c0 .407-.33.733-.739.733a.734.734 0 0 1-.739-.733c0-.405.331-.733.74-.733.407 0 .738.328.738.733Zm2.099.744c-.047-.982-.273-1.852-.998-2.568-.723-.716-1.6-.94-2.59-.99-1.02-.057-4.078-.057-5.098 0-.987.047-1.864.27-2.59.987-.724.717-.948 1.586-.997 2.568-.058 1.011-.058 4.044 0 5.056.047.981.273 1.85.998 2.567.725.717 1.6.94 2.589.99 1.02.058 4.078.058 5.098 0 .99-.046 1.867-.27 2.59-.99.722-.716.948-1.586.998-2.567.058-1.012.058-4.042 0-5.053Zm-1.318 6.138a2.077 2.077 0 0 1-1.175 1.165c-.813.32-2.744.246-3.642.246-.9 0-2.832.071-3.643-.246a2.076 2.076 0 0 1-1.175-1.165c-.322-.806-.248-2.72-.248-3.612 0-.891-.071-2.808.248-3.612a2.077 2.077 0 0 1 1.175-1.165c.814-.32 2.744-.246 3.643-.246.898 0 2.831-.071 3.642.246.54.213.957.626 1.175 1.165.322.807.248 2.72.248 3.612 0 .891.074 2.808-.248 3.612Z" />

                        </svg></a></li>

                <li class="nav-item"><a href="https://www.linkedin.com/in/idg-windtech-6571a8284/" target="_blank" class="nav-link"><svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="18px" height="18px">    <path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"/></svg></a></li>

            </ul>
        </div>
        
    </nav><!-- Navbar mobile-->
    <div class="navbar navbar-mobile navbar-mobile-style-1 bg-white mfp-hide" id="navbar-mobile-style-1">
        <div class="navbar-wrapper">
            <div class="navbar-head"><a class="navbar-brand d-block d-md-none" href="index.php">
				<img src="assets/img/Logo-proyecto.png" width="250" height="123" alt=""/>
</a><a class="navbar-toggle popup-modal-dismiss" href="#"><span></span><span></span><span></span></a></div>
            <div class="navbar-body">
                <ul class="nav navbar-nav navbar-nav-collapse">
					<a class="navbar-toggle order-4 popup-inline" href="#navbar-mobile-style-1"><span></span><span></span><span></span></a>
            <ul class="nav navbar-nav order-2 ms-auto nav-no-opacity">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $lang['Idioma_activo'] ?><svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" fill="none">
                            <path fill="currentColor" d="m5 5-.495.495L5 5.99l.495-.495L5 5ZM.505 1.495l4 4 .99-.99-4-4-.99.99Zm4.99 4 4-4-.99-.99-4 4 .99.99Z" />
                        </svg></a>
                    <ul class="dropdown-menu rounded-2 shadow">
                        <li class="nav-item"><a class="nav-link active" href="about_as.php?lang=en"><?php echo $lang['en'] ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="about_as.php?lang=es"><?php echo $lang['es'] ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="about_as.php?lang=po"><?php echo $lang['po'] ?></a></li>
                    </ul>
                    <li class="nav-item active "><a class="nav-link" href="index.php"><span><?php echo $lang['Home'] ?></span></a>
                       
                    </li>
                     <li class="nav-item "><a class="nav-link" href="services.php"><span><?php echo $lang['Services'] ?></span></a>                        
                    </li>
                     <li class="nav-item "><a class="nav-link" href="about_as.php"><span><?php echo $lang['About'] ?></span></a>                        
                    </li>
                       
                    </li>
                    <li class="nav-item "><a class="nav-link" href="app/login.html" target="_blank"><span><?php echo $lang['Customers'] ?></span></a>                        
                    </li>
                     <li class="nav-item "><a class="nav-link" href="contact.php" target="_blank"><span><?php echo $lang['Contact'] ?></span></a>                        
                    </li>   
                    </li>
                </ul>
            </div>
            <div class="navbar-footer">
                <!-- Contacts-->
                <ul class="list-group borderless font-size-15">
                    <li class="list-group-item">Email: <a href="contact.php">mailto:info@idgwindtech.com</a></li>
                    <!--<li class="list-group-item">Phone: <a href="tel:12023580309">+1 202-358-0309</a></li>-->
                </ul><!-- Social-->
                <ul class="nav nav-gap-sm navbar-nav nav-social mt-30 nav-no-opacity">
                    <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/profile.php?id=100095142120302" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="15" fill="none">
                                <path fill="currentColor" d="M5.93 3.08h1.128V.974A13.651 13.651 0 0 0 5.416.882c-1.626 0-2.74 1.096-2.74 3.11v1.853H.882v2.353h1.794v5.92h2.2v-5.92h1.721l.274-2.353H4.875v-1.62c0-.68.171-1.146 1.056-1.146Z" />
                            </svg></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://www.youtube.com/@IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="13" fill="none">
                                <path fill="currentColor" d="M16.409 2.635a2.004 2.004 0 0 0-1.405-1.423c-1.24-.337-6.21-.337-6.21-.337s-4.971 0-6.21.337a2.004 2.004 0 0 0-1.406 1.423C.846 3.891.846 6.511.846 6.511s0 2.62.332 3.876a1.974 1.974 0 0 0 1.405 1.402c1.24.336 6.21.336 6.21.336s4.971 0 6.21-.336a1.974 1.974 0 0 0 1.406-1.402c.332-1.255.332-3.876.332-3.876s0-2.62-.332-3.876ZM7.168 8.89V4.132l4.154 2.38L7.168 8.89Z" />
                            </svg></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://twitter.com/IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" fill="none">
                                <path fill="currentColor" d="M13.986 3.445c.01.133.01.266.01.4 0 4.064-3.093 8.746-8.747 8.746a8.687 8.687 0 0 1-4.72-1.38c.247.029.485.038.742.038 1.437 0 2.76-.485 3.816-1.313a3.08 3.08 0 0 1-2.874-2.132 3.251 3.251 0 0 0 1.39-.057A3.075 3.075 0 0 1 1.137 4.73v-.038c.41.228.886.37 1.39.39a3.072 3.072 0 0 1-1.37-2.56c0-.571.152-1.095.418-1.552a8.738 8.738 0 0 0 6.34 3.217 3.47 3.47 0 0 1-.077-.704A3.073 3.073 0 0 1 10.912.409c.885 0 1.685.37 2.246.97A6.052 6.052 0 0 0 15.11.637a3.066 3.066 0 0 1-1.352 1.694 6.164 6.164 0 0 0 1.77-.476 6.609 6.609 0 0 1-1.542 1.59Z" />
                            </svg></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://www.instagram.com/idgwindtech/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                                <path fill="currentColor" d="M7.504 4.13c-1.88 0-3.395 1.504-3.395 3.367s1.516 3.366 3.395 3.366 3.394-1.503 3.394-3.366c0-1.863-1.515-3.366-3.394-3.366Zm0 5.556a2.202 2.202 0 0 1-2.207-2.189A2.2 2.2 0 0 1 7.504 5.31 2.2 2.2 0 0 1 9.71 7.497a2.202 2.202 0 0 1-2.207 2.189Zm4.325-5.693a.787.787 0 0 1-.792.785.787.787 0 0 1-.792-.785c0-.433.355-.785.792-.785.437 0 .792.352.792.785Zm2.248.797c-.05-1.052-.293-1.983-1.07-2.75-.774-.769-1.713-1.009-2.774-1.061C9.14.917 5.864.917 4.771.979c-1.058.05-1.997.29-2.774 1.057-.777.768-1.016 1.7-1.07 2.751-.062 1.084-.062 4.333 0 5.417.05 1.052.293 1.983 1.07 2.751.777.768 1.713 1.008 2.774 1.06 1.093.062 4.37.062 5.462 0 1.061-.05 2-.29 2.775-1.06.774-.768 1.016-1.7 1.069-2.75.062-1.085.062-4.331 0-5.415Zm-1.412 6.577a2.225 2.225 0 0 1-1.259 1.248c-.871.343-2.94.264-3.902.264-.963 0-3.034.076-3.903-.264a2.225 2.225 0 0 1-1.259-1.248c-.345-.864-.265-2.915-.265-3.87 0-.955-.077-3.009.265-3.87a2.225 2.225 0 0 1 1.259-1.248c.872-.343 2.94-.264 3.903-.264.963 0 3.034-.076 3.902.264.58.228 1.025.67 1.259 1.248.346.864.266 2.915.266 3.87 0 .955.08 3.009-.266 3.87Z" />
                            </svg></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://www.linkedin.com/in/idg-windtech-6571a8284/" target="_blank" ><svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="18px" height="18px">    <path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"/></svg></a></li>
                </ul>
            </div>
        </div>
    </div>
  <!-- Topbar-->
    <!-- Main-->
    <div class="content-wrap ">
        <!-- Page title-->
        <br><br>
        <div class="position-relative py-210">
            <div class="background">
                <div class="background-image jarallax" data-jarallax data-speed="0.8"><img class="jarallax-img" loading="lazy" src="assets/img/about1.jpg" alt=""></div>
                <div class="background-color" style="--background-color: #000; opacity: .25;"></div>
            </div>
            <div class="container">
                <h1 class="text-white mb-0 text-center"><?php echo $lang['About'] ?>.</h1>
            </div>
        </div>
		<div class="container">
			
        <div class="col-lg-12">
			<br><br><br>
                        <div class="pe-lg-70">
                            <h2 class="mb-45" data-show="startbox" data-show-delay="100"><span class="highlight">IDG Windtech</span></h2>
                            <div class="h4 mb-30" data-show="startbox" data-show-delay="200"> <?php echo $lang['Subtitulo_a'] ?></div>
                            <p class="mb-50" data-show="startbox" data-show-delay="300"><?php echo $lang['descripcion_a'] ?>.</p>
							
                            <div data-show="startbox" data-show-delay="400">
                                <!-- Button--><a class="btn btn-accent-1 btn-link btn-clean" 
								<br><br><br><br><br>
                            </div>
                        </div>
                    </div>
				</div>
			
               </div>
    </div><!-- Footer-->
    <footer class="bg-dark text-white pt-120 pb-100 footerNext">
        <div class="container">
            <div class="row gy-50">
                <div class="col-12 col-lg-3"><a class="d-block mb-30" href="index.html">
                    <img src="assets/img/Logo-proyecto.png" width="" height="80" alt=""/>
                    </a>
                    <p class="font-size-15 mb-35"><?php echo $lang['Slogan']; ?></p>
                    <ul class="nav text-white align-items-center mb-20 nav-gap-md nav-no-opacity">
                        <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/profile.php?id=100095142120302" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="17" fill="none">
                                    <path fill="currentColor" d="M6.318 2.8h1.391V.202A16.842 16.842 0 0 0 5.683.088c-2.006 0-3.38 1.353-3.38 3.837v2.287H.089v2.902h2.214v7.303h2.713V9.114H7.14l.338-2.902H5.016v-2c0-.839.21-1.413 1.302-1.413Z" />
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="https://www.youtube.com/@IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="15" fill="none">
                                    <path fill="currentColor" d="M19.687 2.485A2.472 2.472 0 0 0 17.953.73C16.423.313 10.29.313 10.29.313s-6.133 0-7.662.416A2.473 2.473 0 0 0 .895 2.485c-.41 1.55-.41 4.782-.41 4.782s0 3.233.41 4.782c.226.855.89 1.5 1.734 1.729 1.53.415 7.662.415 7.662.415s6.132 0 7.662-.415a2.435 2.435 0 0 0 1.734-1.729c.41-1.549.41-4.782.41-4.782s0-3.232-.41-4.782ZM8.285 10.203v-5.87l5.126 2.934-5.126 2.936Z" />
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="https://twitter.com/IDGWindTech" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" fill="none">
                                    <path fill="currentColor" d="M17.477 4.484c.012.165.012.329.012.493 0 5.014-3.817 10.792-10.792 10.792-2.149 0-4.145-.623-5.824-1.703.305.035.599.047.916.047a7.596 7.596 0 0 0 4.709-1.62 3.8 3.8 0 0 1-3.547-2.63c.235.034.47.058.717.058.34 0 .68-.047.998-.13A3.793 3.793 0 0 1 1.625 6.07v-.047a3.82 3.82 0 0 0 1.714.482 3.79 3.79 0 0 1-1.691-3.159c0-.704.188-1.35.517-1.914a10.781 10.781 0 0 0 7.82 3.97 4.282 4.282 0 0 1-.094-.87c0-2.09 1.691-3.793 3.793-3.793 1.092 0 2.079.458 2.771 1.198a7.466 7.466 0 0 0 2.408-.916c-.282.88-.881 1.62-1.668 2.09a7.604 7.604 0 0 0 2.184-.587 8.153 8.153 0 0 1-1.902 1.961Z" />
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="https://www.instagram.com/idgwindtech/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none">
                                    <path fill="currentColor" d="M8.788 4.097C6.47 4.097 4.6 5.95 4.6 8.25c0 2.298 1.87 4.153 4.188 4.153 2.318 0 4.188-1.855 4.188-4.153 0-2.3-1.87-4.153-4.188-4.153Zm0 6.853c-1.498 0-2.723-1.211-2.723-2.7 0-1.49 1.221-2.7 2.723-2.7 1.502 0 2.723 1.21 2.723 2.7 0 1.489-1.225 2.7-2.723 2.7Zm5.336-7.023a.97.97 0 0 1-.977.968.97.97 0 0 1-.976-.968c0-.535.437-.969.976-.969.54 0 .977.434.977.969Zm2.774.983c-.062-1.298-.36-2.447-1.32-3.394C14.624.569 13.465.272 12.156.207c-1.349-.076-5.39-.076-6.74 0C4.113.27 2.954.565 1.995 1.512 1.035 2.46.74 3.61.674 4.906c-.076 1.338-.076 5.346 0 6.683.063 1.298.361 2.447 1.32 3.394.959.947 2.114 1.244 3.423 1.309 1.348.076 5.39.076 6.739 0 1.308-.062 2.468-.358 3.422-1.309.956-.947 1.254-2.096 1.32-3.394.076-1.337.076-5.342 0-6.68Zm-1.742 8.114a2.745 2.745 0 0 1-1.553 1.54c-1.075.423-3.627.325-4.815.325-1.188 0-3.743.095-4.815-.325a2.746 2.746 0 0 1-1.552-1.54c-.427-1.066-.329-3.596-.329-4.774 0-1.179-.094-3.712.329-4.775a2.745 2.745 0 0 1 1.552-1.54C5.048 1.512 7.6 1.61 8.788 1.61c1.188 0 3.743-.094 4.815.325a2.745 2.745 0 0 1 1.553 1.54c.426 1.066.328 3.596.328 4.775 0 1.178.098 3.712-.328 4.774Z" />
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="https://www.linkedin.com/in/idg-windtech-6571a8284/" target="_blank"><svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="18px" height="18px">    <path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"/></svg></a></li>
                    </ul>
                    <p class="font-size-13 text-muted m-0">© 2022 Designed by IDG Windtech.</p>
                </div>
                <div class="col-2 d-none d-lg-block"></div>
                <div class="col-12 col-lg-7">
                    <div class="row gy-50">
                        <div class="col-6 col-md-4">
                            <!--<a class="nav-link" href="#services">
                            <h6 class="display-6 text-white mb-20">Services</h6></a>-->
                            
                        </div>
                        <div class="col-6 col-md-4">
                           <!-- <h6 class="display-6 text-white mb-20">About</h6>-->
                            
                        </div>
						
                        <div class="col-6 col-md-4">
							
                            <h6 class="display-6 text-white mb-20"><?php echo $lang['Contact'] ?></h6>
                            <ul class="nav flex-column text-white nav-opacity nav-gap-sm">
                                <li class="nav-item"><a class="nav-link" href="info@idgwindtech.com">info@idgwindtech.com</a></li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- Vendors-->
    <!-- build:js -->
    <script src="assets/vendors/js/bootstrap.js"></script>
    <script src="assets/vendors/js/imagesloaded.pkgd.js"></script>
    <script src="assets/vendors/js/isotope.pkgd.js"></script>
    <script src="assets/vendors/js/jarallax.js"></script>
    <script src="assets/vendors/js/jarallax-element.js"></script>
    <script src="assets/vendors/js/jquery.countdown.js"></script>
    <script src="assets/vendors/js/jquery.magnific-popup.js"></script>
    <script src="assets/vendors/js/ofi.js"></script>
    <script src="assets/vendors/js/jquery.inview.js"></script>
    <script src="assets/vendors/js/swiper-bundle.js"></script>
    <script src="assets/vendors/js/gist-embed.min.js"></script>
    <script src="assets/js/helpers.js"></script>
    <script src="assets/js/controllers/show-on-scroll.js"></script>
    <script src="assets/js/controllers/countdown.js"></script>
    <script src="assets/js/controllers/isotope.js"></script>
    <script src="assets/js/controllers/navbar.js"></script>
    <script src="assets/js/controllers/stretch-column.js"></script>
    <script src="assets/js/controllers/swiper.js"></script>
    <script src="assets/js/controllers/others.js"></script><!-- endbuild -->
</body>

</html>