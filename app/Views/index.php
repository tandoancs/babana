<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="babana Trà sữa Mì cay">
    <meta name="author" content="Tan Doan">
    <meta name="keywords" content="babana Trà sữa Mì cay">


    <!-- Title Page-->
    <title>Babana Admin</title>
    <!-- icon -->
    <link rel="icon" href="frontend/images/icon/logo-icon.png" type="image/x-icon" />

    <!-- Fontfaces CSS-->
    <link href="frontend/css/font-face.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="frontend/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="frontend/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="frontend/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- css tùy chỉnh -->
    <link href="frontend/css/style.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="frontend/css/theme.css" rel="stylesheet" media="all">

    <!-- dtmlx 8 -->
    <link rel="stylesheet" href="<?php echo base_url('suite/codebase/suite.css?v=8.2.1'); ?>">

    <!-- bootrap css -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/4.4.95/css/materialdesignicons.css?v=6.4.2" media="all" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css">




</head>

<body class="animsition" style="height: 100%; width: 100%;">
    <div class="page-wrapper" style="height: 100%; width: 100%;">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="section__content section__content--p35">
                <div class="header3-wrap">
                    <div class="header__logo">
                        <a href="./">
                            <img src="frontend/images/icon/logo-icon.png" width="90px" alt="Babana" />
                            <img src="frontend/images/icon/logo-text.png" width="190px" alt="Babana" style="position: relative; left: -40px;" />
                        </a>
                    </div>
                    <div class="header__navbar">
                        <ul class="list-unstyled">
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                    <span class="bot-line"></span>
                                </a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="#">Dashboard 1</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 3</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fas fa-shopping-basket"></i>
                                    <span class="bot-line"></span>eCommerce</a>
                            </li>
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-chart-bar"></i><span class="bot-line"></span>Chức năng
                                </a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="#" id="transaction">Quản lý Thu/Chi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="reports">Báo cáo</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-database"></i>
                                    <span class="bot-line"></span>Quản lý dữ liệu
                                </a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="#" id="area">Khu vực chổ ngồi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="table-order">Bàn</a>
                                    </li>
                                    <li>
                                        <a href="#" id="food">Sản phẩm</a>
                                    </li>

                                    <li>
                                        <a href="#" id="menu">Menu</a>
                                    </li>


                                    <li>
                                        <a href="#" id="promotion">Khuyến mãi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="size">Kích cỡ (Size)</a>
                                    </li>
                                    <li>
                                        <a href="#" id="unit">Đơn vị sản phẩm</a>
                                    </li>
                                    <li>
                                        <a href="#" id="size-unit">Kích thước + Đơn vị</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li class="has-sub">
                                <a href="frontend/#">
                                    <i class="fas fa-desktop"></i>
                                    <span class="bot-line"></span>UI Elements</a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="frontend/button.html">Button</a>
                                    </li>
                                    <li>
                                        <a href="frontend/badge.html">Badges</a>
                                    </li>
                                    <li>
                                        <a href="frontend/tab.html">Tabs</a>
                                    </li>
                                    <li>
                                        <a href="frontend/card.html">Cards</a>
                                    </li>
                                    <li>
                                        <a href="frontend/alert.html">Alerts</a>
                                    </li>
                                    <li>
                                        <a href="frontend/progress-bar.html">Progress Bars</a>
                                    </li>
                                    <li>
                                        <a href="frontend/modal.html">Modals</a>
                                    </li>
                                    <li>
                                        <a href="frontend/switch.html">Switchs</a>
                                    </li>
                                    <li>
                                        <a href="frontend/grid.html">Grids</a>
                                    </li>
                                    <li>
                                        <a href="frontend/fontawesome.html">FontAwesome</a>
                                    </li>
                                    <li>
                                        <a href="frontend/typo.html">Typography</a>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                    <div class="header__tool">
                        <div class="header-button-item has-noti js-item-menu">
                            <i class="zmdi zmdi-notifications"></i>
                            <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                                <div class="notifi__title">
                                    <p>You have 3 Notifications</p>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c1 img-cir img-40">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a email notification</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c2 img-cir img-40">
                                        <i class="zmdi zmdi-account-box"></i>
                                    </div>
                                    <div class="content">
                                        <p>Your account has been blocked</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c3 img-cir img-40">
                                        <i class="zmdi zmdi-file-text"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a new file</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__footer">
                                    <a href="frontend/#">All notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="header-button-item js-item-menu">
                            <i class="zmdi zmdi-settings"></i>
                            <div class="setting-dropdown js-dropdown">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-globe"></i>Language</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-pin"></i>Location</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-email"></i>Email</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-notifications"></i>Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <div class="image">
                                    <img src="frontend/images/icon/avatar-01.jpg" alt="Luna" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="frontend/#">Luna</a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="frontend/#">
                                                <img src="frontend/images/icon/avatar-01.jpg" alt=" Luna" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="frontend/#">Luna</a>
                                            </h5>
                                            <span class="email">dathao280393@gmail.com</span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="frontend/#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="frontend/#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="frontend/#">
                                                <i class="zmdi zmdi-money-box"></i>Billing</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="frontend/#">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- HEADER MOBILE-->
        <header class="header-mobile header-mobile-2 d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="frontend/index.html">
                            <img src="frontend/images/icon/logo-icon.png" width="90px" alt="Babana" />
                            <img src="frontend/images/icon/logo-text.png" width="190px" alt="Babana" style="position: relative; left: -40px;" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="frontend/#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="frontend/index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="frontend/index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="frontend/index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="frontend/index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="frontend/chart.html">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="frontend/table.html">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="frontend/form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li>
                            <a href="frontend/calendar.html">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                        </li>
                        <li>
                            <a href="frontend/map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="frontend/#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="frontend/login.html">Login</a>
                                </li>
                                <li>
                                    <a href="frontend/register.html">Register</a>
                                </li>
                                <li>
                                    <a href="frontend/forget-pass.html">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="frontend/#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="frontend/button.html">Button</a>
                                </li>
                                <li>
                                    <a href="frontend/badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="frontend/tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="frontend/card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="frontend/alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="frontend/progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="frontend/modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="frontend/switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="frontend/grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="frontend/fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="frontend/typo.html">Typography</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="sub-header-mobile-2 d-block d-lg-none">
            <div class="header__tool">
                <div class="header-button-item has-noti js-item-menu">
                    <i class="zmdi zmdi-notifications"></i>
                    <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                        <div class="notifi__title">
                            <p>You have 3 Notifications</p>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c1 img-cir img-40">
                                <i class="zmdi zmdi-email-open"></i>
                            </div>
                            <div class="content">
                                <p>You got a email notification</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c2 img-cir img-40">
                                <i class="zmdi zmdi-account-box"></i>
                            </div>
                            <div class="content">
                                <p>Your account has been blocked</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c3 img-cir img-40">
                                <i class="zmdi zmdi-file-text"></i>
                            </div>
                            <div class="content">
                                <p>You got a new file</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__footer">
                            <a href="frontend/#">All notifications</a>
                        </div>
                    </div>
                </div>
                <div class="header-button-item js-item-menu">
                    <i class="zmdi zmdi-settings"></i>
                    <div class="setting-dropdown js-dropdown">
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-account"></i>Account</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-globe"></i>Language</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-pin"></i>Location</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-email"></i>Email</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-notifications"></i>Notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                            <img src="frontend/images/icon/avatar-01.jpg" alt="Luna" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="frontend/#">Luna</a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="frontend/#">
                                        <img src="frontend/images/icon/avatar-01.jpg" alt="Luna" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="frontend/#">Luna</a>
                                    </h5>
                                    <span class="email">dathao280393@gmail.com</span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="frontend/#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="frontend/#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="frontend/#">
                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                </div>
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="frontend/#">
                                    <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->

        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7" style="height: 80%; ">

            <!-- -------------------------------------------------------------------------------------------
                |
                | layout
                |
             -->
            <div class="container-fluid" style="height: 100%; width: 100%;">
                <!-- component container -->
                <div id="toolbar_container"></div>
                <div style="height: calc(100% - 61px); width:100%;" id="grid_container"></div>
            </div>



            <!-- COPYRIGHT-->
            <section class="p-t-60 p-b-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2023 Babana. Developer by <a href="https://codeclean.org">Tan Doan</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END COPYRIGHT-->
        </div>

    </div>

    <!-- ----------------------------------------------------------------------------------------------------
        |
        | js libraries
        |
     -->

    <script>

    </script>

    <!-- Jquery JS-->
    <!-- <script src="frontend/vendor/jquery-3.2.1.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS-->
    <script src="frontend/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="frontend/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="frontend/vendor/slick/slick.min.js">
    </script>
    <script src="frontend/vendor/wow/wow.min.js"></script>
    <script src="frontend/vendor/animsition/animsition.min.js"></script>
    <script src="frontend/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="frontend/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="frontend/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="frontend/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="frontend/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="frontend/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="frontend/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="frontend/js/main.js"></script>


    <!-- dhtmlx 8 -->
    <script type="text/javascript" src="<?php echo base_url('suite/codebase/suite.js?v=8.2.1'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('suite/common/data.js?v=8.2.1'); ?>"></script>

    <!-- bootrap js -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- template js -->
    <script type="text/javascript" src="<?php echo base_url('templatejs/jsFunctions.js'); ?>"></script>


</body>

</html>
<!-- end document-->