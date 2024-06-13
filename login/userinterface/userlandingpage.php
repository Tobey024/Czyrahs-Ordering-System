<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', or 'Employee' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'User' && $_SESSION['type'] != 'Admin')) {
    // Redirect to the login page
    header("Location: ../logout.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="pizzatitle.png">
        <title>Czyrah's Pizza</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free Website Template" name="keywords">
        <meta content="Free Website Template" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Nunito:600,700" rel="stylesheet"> 
        
        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    </head>
    <style>
        /*******************************/
/********* General CSS *********/
/*******************************/
body {
    color: #757575;
    background: #ffffff;
    font-family: 'open sans', sans-serif;
}

h1,
h2, 
h3, 
h4,
h5, 
h6 {
    color: #454545;
    font-family: 'Nunito', sans-serif;
}

a {
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
    color: #fbaf32;
    transition: .3s;
}

a:hover,
a:active,
a:focus {
    color: #719a0a;
    outline: none;
    text-decoration: none;
}

.btn.custom-btn {
    padding: 12px 25px;
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    background: #fbaf32;
    border: 2px solid #fbaf32;
    border-radius: 5px;
    transition: .5s;
}

.btn.custom-btn:hover {
    color: #fbaf32;
    background: transparent;
}

.btn.custom-btn:focus,
.form-control:focus,
.custom-select:focus {
    box-shadow: none;
}

.container-fluid {
    max-width: 1366px;
}

.back-to-top {
    position: fixed;
    display: none;
    background: #fbaf32;
    width: 44px;
    height: 44px;
    text-align: center;
    line-height: 1;
    font-size: 22px;
    right: 15px;
    bottom: 15px;
    border-radius: 5px;
    transition: background 0.5s;
    z-index: 9;
}

.back-to-top i {
    color: #ffffff;
    padding-top: 10px;
}

.back-to-top:hover {
    background: #719a0a;
}

[class^="flaticon-"]:before, [class*=" flaticon-"]:before,
[class^="flaticon-"]:after, [class*=" flaticon-"]:after {   
    font-size: inherit;
    margin-left: 0;
}


/**********************************/
/*********** Nav Bar CSS **********/
/**********************************/
.navbar {
    position: relative;
    transition: .5s;
    z-index: 999;
}

.navbar.nav-sticky {
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .3);
}

.navbar .navbar-brand {
    margin: 0;
    color: #fbaf32;
    font-size: 35px;
    line-height: 0px;
    font-weight: 700;
    font-family: 'Nunito', sans-serif;
    transition: .5s;
    
}

.navbar .navbar-brand span {
    color: #719a0a;
}

.navbar .navbar-brand:hover {
    color: #4fd845;
}

.navbar .navbar-brand:hover span {
    color: #4fd845;
}

.navbar .navbar-brand img {
    max-width: 100%;
    max-height: 40px;
}

.navbar .dropdown-menu {
    margin-top: 0;
    border: 0;
    border-radius: 0;
    background: #f8f9fa;
}

@media (min-width: 992px) {
    .navbar {
        position: absolute;
        width: 100%;
        padding: 30px 60px;
        background: transparent !important;
        z-index: 9;
    }
    
    .navbar.nav-sticky {
        padding: 10px 60px;
        background: #ffffff !important;
    }
    
    .navbar .navbar-brand {
        color: #4fd845;
    }
    
    .navbar.nav-sticky .navbar-brand {
        color: #4fd845;
    }

    .navbar-light .navbar-nav .nav-link,
    .navbar-light .navbar-nav .nav-link:focus {
        padding: 10px 10px 8px 10px;
        font-family: 'Nunito', sans-serif;
        color: #ffffff;
        font-size: 18px;
        font-weight: 600;
    }
    
    .navbar-light.nav-sticky .navbar-nav .nav-link,
    .navbar-light.nav-sticky .navbar-nav .nav-link:focus {
        color: #666666;
    }

    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #4fd845;
    }
    
    .navbar-light.nav-sticky .navbar-nav .nav-link:hover,
    .navbar-light.nav-sticky .navbar-nav .nav-link.active {
        color: #4fd845;
    }
}

@media (max-width: 991.98px) {   
    .navbar {
        padding: 15px;
        background: #ffffff !important;
    }
    
    .navbar .navbar-brand {
        color: #4fd845;
    }
    
    .navbar .navbar-nav {
        margin-top: 15px;
    }
    
    .navbar a.nav-link {
        padding: 5px;
    }
    
    .navbar .dropdown-menu {
        box-shadow: none;
    }
}


/*******************************/
/********** Hero CSS ***********/
/*******************************/
.carousel {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 400px;
    background: #000000;
}

.carousel .container-fluid {
    padding: 0;
}

.carousel .carousel-item {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.carousel .carousel-img {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: right;
    overflow: hidden;
}

.carousel .carousel-img::after {
    position: absolute;
    content: "";
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

.carousel .carousel-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.carousel .carousel-text {
    position: absolute;
    max-width: 700px;
    height: calc(100vh - 35px);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    z-index: 2;
}

.carousel .carousel-text h1 {
    text-align: center;
    color: #ffffff;
    font-size: 60px;
    font-weight: 700;
    margin-bottom: 30px;
}

.carousel .carousel-text h1 span {
    color: #fbaf32;
}

.carousel .carousel-text p {
    color: #ffffff;
    text-align: center;
    font-size: 20px;
    margin-bottom: 35px;
}

.carousel .carousel-btn .btn:last-child {
    margin-left: 10px;
    background: #719a0a;
    border-color: #719a0a;
}

.carousel .carousel-btn .btn:last-child:hover {
    color: #719a0a;
    background: transparent;
}

.carousel .animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
}

@media (max-width: 991.98px) {
    .carousel,
    .carousel .carousel-item,
    .carousel .carousel-text {
        height: calc(100vh - 105px);
    }
    
    .carousel .carousel-text h1 {
        font-size: 35px;
    }
    
    .carousel .carousel-text p {
        font-size: 16px;
    }
    
    .carousel .carousel-text .btn {
        padding: 12px 30px;
        font-size: 15px;
        letter-spacing: 0;
    }
}

@media (max-width: 767.98px) {
    .carousel,
    .carousel .carousel-item,
    .carousel .carousel-text {
        height: calc(100vh - 70px);
    }
    
    .carousel .carousel-text h1 {
        font-size: 30px;
    }
    
    .carousel .carousel-text .btn {
        padding: 10px 25px;
        font-size: 15px;
        letter-spacing: 0;
    }
}

@media (max-width: 575.98px) {
    .carousel .carousel-text h1 {
        font-size: 25px;
    }
    
    .carousel .carousel-text .btn {
        padding: 8px 20px;
        font-size: 14px;
        letter-spacing: 0;
    }
}


/*******************************/
/******* Page Header CSS *******/
/*******************************/
.page-header {
    position: relative;
    margin-bottom: 45px;
    padding: 150px 0 90px 0;
    text-align: center;
    background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(../img/page-header.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.page-header h2 {
    position: relative;
    color: #4fd845;
    font-size: 60px;
    font-weight: 700;
}

.page-header a {
    position: relative;
    padding: 0 12px;
    font-size: 20px;
    text-transform: uppercase;
    color: #ffffff;
}

.page-header a:hover {
    color: #ffffff;
}

.page-header a::after {
    position: absolute;
    content: "/";
    width: 8px;
    height: 8px;
    top: -1px;
    right: -7px;
    text-align: center;
    color: #fbaf32;
}

.page-header a:last-child::after {
    display: none;
}

@media (max-width: 767.98px) {
    .page-header h2 {
        font-size: 35px;
    }
    
    .page-header a {
        font-size: 18px;
    }
}


/*******************************/
/******* Section Header ********/
/*******************************/
.section-header {
    position: relative;
    margin-bottom: 45px;
}

.section-header p {
    color: #719a0a;
    margin-bottom: 5px;
    position: relative;
    font-size: 20px;
}

.section-header h2 {
    margin: 0;
    position: relative;
    font-size: 45px;
    font-weight: 700;
}

@media (max-width: 991.98px) {
    .section-header h2 {
        font-size: 40px;
        font-weight: 600;
    }
}

@media (max-width: 767.98px) {
    .section-header h2 {
        font-size: 35px;
        font-weight: 600;
    }
}

@media (max-width: 575.98px) {
    .section-header h2 {
        font-size: 30px;
        font-weight: 600;
    }
}
/*******************************/
/********** Menu CSS ***********/
/*******************************/
.food {
    position: relative;
    width: 100%;
    padding: 90px 0 60px 0;
    margin: 45px 0;
    background: rgba(0, 0, 0, .04);
}

.food .food-item {
    position: relative;
    width: 100%;
    margin-bottom: 30px;
    padding: 50px 30px 30px;
    text-align: center;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 30px rgba(0, 0, 0, .08);
    transition: .3s;
}

.food .food-item:hover {
    box-shadow: none;
}

.food .food-item i {
    position: relative;
    display: inline-block;
    color: #fbaf32;
    font-size: 60px;
    line-height: 60px;
    margin-bottom: 20px;
    transition: .3s;
}

.food .food-item:hover i {
    color: #719a0a;
}

.food .food-item i::after {
    position: absolute;
    content: "";
    width: calc(100% + 20px);
    height: calc(100% + 20px);
    top: -20px;
    left: -15px;
    border: 3px dotted #fbaf32;
    border-right: transparent;
    border-bottom: transparent;
    border-radius: 100px;
    transition: .3s;
}

.food .food-item:hover i::after {
    border: 3px dotted #719a0a;
    border-right: transparent;
    border-bottom: transparent;
}

.food .food-item h2 {
    font-size: 30px;
    font-weight: 700;
}

.food .food-item a {
    position: relative;
    font-size: 16px;
}

.food .food-item a::after {
    position: absolute;
    content: "";
    width: 50px;
    height: 1px;
    bottom: 0;
    left: calc(50% - 25px);
    background: #fbaf32;
    transition: .3s;
}

.food .food-item a:hover::after {
    width: 100%;
    left: 0;
    background: #719a0a;
}



/*******************************/
/********** About CSS **********/
/*******************************/
.about {
    position: relative;
    width: 100%;
    padding: 45px 0;
}

.about .section-header {
    margin-bottom: 30px;
    margin-left: 0;
}

.about .about-img {
    position: relative;
}

.about .about-img img {
    position: relative;
    width: 100%;
    border-radius: 15px;
}

.about .btn-play {
    position: absolute;
    z-index: 1;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    box-sizing: content-box;
    display: block;
    width: 32px;
    height: 44px;
    border-radius: 50%;
    border: none;
    outline: none;
    padding: 18px 20px 18px 28px;
}

.about .btn-play:before {
    content: "";
    position: absolute;
    z-index: 0;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 100px;
    height: 100px;
    background: #fbaf32;
    border-radius: 50%;
    animation: pulse-border 1500ms ease-out infinite;
}

.about .btn-play:after {
    content: "";
    position: absolute;
    z-index: 1;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 100px;
    height: 100px;
    background: #fbaf32;
    border-radius: 50%;
    transition: all 200ms;
}

.about .btn-play img {
    position: relative;
    z-index: 3;
    max-width: 100%;
    width: auto;
    height: auto;
}

.about .btn-play span {
    display: block;
    position: relative;
    z-index: 3;
    width: 0;
    height: 0;
    border-left: 32px solid #ffffff;
    border-top: 22px solid transparent;
    border-bottom: 22px solid transparent;
}

@keyframes pulse-border {
  0% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
    opacity: 0;
  }
}

.about .about-content {
    position: relative;
}

.about .about-text p {
    font-size: 16px;
}

.about .about-text a.btn {
    position: relative;
    margin-top: 15px;
}

@media (max-width: 991.98px) {
    .about .about-img {
        margin-bottom: 30px;
    }
}


/*******************************/
/********* Feature CSS *********/
/*******************************/
.feature {
    position: relative;
    width: 100%;
    padding: 45px 0 0 0;
}

.feature .section-header {
    margin-bottom: 30px;
}

.feature .feature-text {
    position: relative;
    width: 100%;
}

.feature .feature-img {
    border-radius: 15px;
    margin-bottom: 25px;
    overflow: hidden;
}

.feature .feature-img .col-6,
.feature .feature-img .col-12 {
    padding: 0;
    overflow: hidden;
}

.feature .feature-img img {
    width: 100%;
    transition: .3s;
}

.feature .feature-img img:hover {
    transform: scale(1.1);
}

.feature .feature-text .buttonabout {
    width: 100%;
    margin-top: 15px;
    margin-bottom: 45px;
}

.feature .feature-item {
    width: 100%;
    margin-bottom: 45px;
}

.feature .feature-item i {
    position: relative;
    display: block;
    color: #719a0a;
    font-size: 60px;
    line-height: 60px;
    margin-bottom: 15px;
    background-image: linear-gradient(#719a0a, #fbaf32);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.feature .feature-item i::after {
    position: absolute;
    content: "";
    width: 40px;
    height: 40px;
    top: -10px;
    left: 20px;
    background: #fbaf32;
    border-radius: 30px;
    z-index: -1;
}

.feature .feature-item h3 {
    font-size: 22px;
    font-weight: 700;
}


/*******************************/
/*********** Menu CSS **********/
/*******************************/
.menu {
    position: relative;
    padding: 45px 0 15px 0;
}

.menu .menu-tab {
    position: relative;
}

.menu .menu-tab img {
    max-width: 100%;
    border-radius: 15px;
}

.menu .menu-tab .nav.nav-pills .nav-link {
    color: #ffffff;
    background: #fbaf32;
    border-radius: 5px;
    margin: 0 5px;
}

.menu .menu-tab .nav.nav-pills .nav-link:hover,
.menu .menu-tab .nav.nav-pills .nav-link.active {
    color: #ffffff;
    background: #719a0a;
}

.menu .menu-tab .tab-content {
    padding: 30px 0 0 0;
    background: transparent;
}

.menu .menu-tab .tab-content .container {
    padding: 0;
}

.menu .menu-item {
    position: relative;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
}

.menu .menu-img {
    width: 80px;
    margin-right: 20px;
}

.menu .menu-img img {
    width: 100%;
    border-radius: 100px;
}

.menu .menu-text {
    width: calc(100% - 100px);
}

.menu .menu-text h3 {
    position: relative;
    display: block;
    font-size: 22px;
    font-weight: 700;
}

.menu .menu-text h3::after {
    position: absolute;
    content: "";
    width: 100%;
    height: 0;
    top: 13px;
    left: 0;
    border-top: 2px dotted #cccccc;
    z-index: -1;
}

.menu .menu-text h3 span {
    display: inline-block;
    float: left;
    padding-right: 5px;
    background: #ffffff;
}

.menu .menu-text h3 strong {
    display: inline-block;
    float: right;
    padding-left: 5px;
    color: #fbaf32;
    background: #ffffff;
}

.menu .menu-text p {
    position: relative;
    margin: 5px 0 0 0;
    float: left;
    display: block;
}

@media(max-width: 575.98px) {
    .menu .menu-text p,
    .menu .menu-text h3,
    .menu .menu-text h3 span,
    .menu .menu-text h3 strong {
        display: block;
        float: none;
        padding: 0;
        margin: 0;
    }
    
    .menu .menu-text h3 {
        font-size: 18px;
        margin-bottom: 0;
    }
    
    .menu .menu-text h3 span {
        margin-bottom: 3px;
    }
    
    .menu .menu-text h3::after {
        display: none;
    }
}


/*******************************/
/*********** Team CSS **********/
/*******************************/
.team {
    position: relative;
    width: 100%;
    padding: 45px 0 15px 0;
}

.team .team-item {
    position: relative;
    margin-bottom: 30px;
    background: #ffffff;
}

.team .team-img {
    position: relative;
    border-radius: 15px 15px 0 0;
    overflow: hidden;
}

.team .team-img img {
    position: relative;
    width: 100%;
    margin-top: 15px;
    transform: scale(1.1);
    transition: .3s;
}

.team .team-item:hover img {
    margin-top: 0;
    margin-bottom: 15px;
}

.team .team-social {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .5s;
}

.team .team-social a {
    position: relative;
    margin: 0 3px;
    margin-top: 100px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 40px;
    font-size: 16px;
    color: #ffffff;
    background: #fbaf32;
    opacity: 0;
}

.team .team-social a:hover {
    color: #ffffff;
    background: #719a0a;
}

.team .team-item:hover .team-social {
    background: rgba(256, 256, 256, .5);
}

.team .team-item:hover .team-social a:first-child {
    opacity: 1;
    margin-top: 0;
    transition: .3s 0s;
}

.team .team-item:hover .team-social a:nth-child(2) {
    opacity: 1;
    margin-top: 0;
    transition: .3s .1s;
}

.team .team-item:hover .team-social a:nth-child(3) {
    opacity: 1;
    margin-top: 0;
    transition: .3s .2s;
}

.team .team-item:hover .team-social a:nth-child(4) {
    opacity: 1;
    margin-top: 0;
    transition: .3s .3s;
}

.team .team-text {
    position: relative;
    padding: 25px 15px;
    text-align: center;
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, .07);
    border-top: none;
    border-radius: 0 0 15px 15px;
}

.team .team-text h2 {
    font-size: 22px;
    font-weight: 700;
}

.team .team-text p {
    margin: 0;
    font-size: 16px;
}

/*******************************/
/******* Single Post CSS *******/
/*******************************/
.single {
    position: relative;
    padding: 45px 0;
}

.single .single-content {
    position: relative;
    margin-bottom: 30px;
    overflow: hidden;
}

.single .single-content img {
    margin-bottom: 20px;
    width: 100%;
}

.single .single-tags {
    margin: -5px -5px 41px -5px;
    font-size: 0;
}

.single .single-tags a {
    margin: 5px;
    display: inline-block;
    padding: 7px 15px;
    font-size: 14px;
    font-weight: 400;
    color: #fbaf32;
    border: 1px solid #dddddd;
    border-radius: 5px;
}

.single .single-tags a:hover {
    color: #ffffff;
    background: #fbaf32;
    border-color: #fbaf32;
}

.single .single-bio {
    margin-bottom: 45px;
    padding: 30px;
    background: rgba(0, 0, 0, .04);
    display: flex;
}

.single .single-bio-img {
    width: 100%;
    max-width: 100px;
}

.single .single-bio-img img {
    width: 100%;
    border-radius: 100px;
}

.single .single-bio-text {
    padding-left: 30px;
}

.single .single-bio-text h3 {
    font-size: 20px;
    font-weight: 700;
}

.single .single-bio-text p {
    margin: 0;
}

.single .single-related {
    margin-bottom: 45px;
}

.single .single-related h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 25px;
}

.single .related-slider {
    position: relative;
    margin: 0 -15px;
    width: calc(100% + 30px);
}

.single .related-slider .post-item {
    margin: 0 15px;
}

.single .post-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.single .post-item .post-img {
    width: 100%;
    max-width: 80px;
}

.single .post-item .post-img img {
    width: 100%;
    border-radius: 5px;
}

.single .post-item .post-text {
    padding-left: 15px;
}

.single .post-item .post-text a {
    color: #757575;
    font-size: 17px;
}

.single .post-item .post-text a:hover {
    color: #fbaf32;
}

.single .post-item .post-meta {
    display: flex;
    margin-top: 8px;
}

.single .post-item .post-meta p {
    display: inline-block;
    margin: 0;
    padding: 0 3px;
    font-size: 14px;
    font-weight: 300;
    font-style: italic;
}

.single .post-item .post-meta p a {
    margin-left: 5px;
    color: #999999;
    font-size: 14px;
    font-weight: 300;
    font-style: normal;
}

.single .related-slider .owl-nav {
    position: absolute;
    width: 90px;
    top: -55px;
    right: 15px;
    display: flex;
}

.single .related-slider .owl-nav .owl-prev,
.single .related-slider .owl-nav .owl-next {
    margin-left: 15px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    background: #fbaf32;
    font-size: 16px;
    transition: .3s;
}

.single .related-slider .owl-nav .owl-prev:hover,
.single .related-slider .owl-nav .owl-next:hover {
    color: #ffffff;
    background: #719a0a;
}

.single .single-comment {
    position: relative;
    margin-bottom: 45px;
}

.single .single-comment h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 25px;
}

.single .comment-list {
    list-style: none;
    padding: 0;
}

.single .comment-child {
    list-style: none;
}

.single .comment-body {
    display: flex;
    margin-bottom: 30px;
}

.single .comment-img {
    width: 60px;
}

.single .comment-img img {
    width: 100%;
    border-radius: 100px;
}

.single .comment-text {
    padding-left: 15px;
    width: calc(100% - 60px);
}

.single .comment-text h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 3px;
}

.single .comment-text span {
    display: block;
    font-size: 14px;
    font-weight: 300;
    margin-bottom: 5px;
}

.single .comment-text .btn {
    padding: 3px 10px;
    font-size: 14px;
    color: #454545;
    background: #dddddd;
    border-radius: 5px;
}

.single .comment-text .btn:hover {
    background: #fbaf32;
}

.single .comment-form {
    position: relative;
}

.single .comment-form h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 25px;
}

.single .comment-form form {
    padding: 30px;
    background: #f3f6ff;
}

.single .comment-form form .form-group:last-child {
    margin: 0;
}

.single .comment-form input,
.single .comment-form textarea {
    border-radius: 5px;
}


/**********************************/
/*********** Sidebar CSS **********/
/**********************************/
.sidebar {
    position: relative;
    width: 100%;
}

@media(max-width: 991.98px) {
    .sidebar {
        margin-top: 45px;
    }
}

.sidebar .sidebar-widget {
    position: relative;
    margin-bottom: 45px;
}

.sidebar .sidebar-widget .widget-title {
    position: relative;
    margin-bottom: 30px;
    padding-bottom: 5px;
    font-size: 25px;
    font-weight: 700;
}

.sidebar .sidebar-widget .widget-title::after {
    position: absolute;
    content: "";
    width: 60px;
    height: 2px;
    bottom: 0;
    left: 0;
    background: #fbaf32;
}

.sidebar .sidebar-widget .search-widget {
    position: relative;
}

.sidebar .search-widget input {
    height: 50px;
    border: 1px solid #dddddd;
    border-radius: 5px;
}

.sidebar .search-widget input:focus {
    box-shadow: none;
}

.sidebar .search-widget .btn {
    position: absolute;
    top: 6px;
    right: 15px;
    height: 40px;
    padding: 0;
    font-size: 25px;
    color: #fbaf32;
    background: none;
    border-radius: 0;
    border: none;
    transition: .3s;
}

.sidebar .search-widget .btn:hover {
    color: #719a0a;
}

.sidebar .sidebar-widget .recent-post {
    position: relative;
}

.sidebar .sidebar-widget .tab-post {
    position: relative;
}

.sidebar .tab-post .nav.nav-pills .nav-link {
    color: #ffffff;
    background: #fbaf32;
    border-radius: 0;
}

.sidebar .tab-post .nav.nav-pills .nav-link:hover,
.sidebar .tab-post .nav.nav-pills .nav-link.active {
    color: #ffffff;
    background: #719a0a;
}

.sidebar .tab-post .tab-content {
    padding: 15px 0 0 0;
    background: transparent;
}

.sidebar .tab-post .tab-content .container {
    padding: 0;
}

.sidebar .sidebar-widget .category-widget {
    position: relative;
}

.sidebar .category-widget ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar .category-widget ul li {
    margin: 0 0 12px 22px; 
}

.sidebar .category-widget ul li:last-child {
    margin-bottom: 0; 
}

.sidebar .category-widget ul li a {
    display: inline-block;
    line-height: 23px;
}

.sidebar .category-widget ul li::before {
    position: absolute;
    content: '\f105';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    color: #fbaf32;
    left: 1px;
}

.sidebar .category-widget ul li span {
    display: inline-block;
    float: right;
}

.sidebar .sidebar-widget .tag-widget {
    position: relative;
    margin: -5px -5px;
}

.single .tag-widget a {
    margin: 5px;
    display: inline-block;
    padding: 7px 15px;
    font-size: 14px;
    font-weight: 400;
    color: #fbaf32;
    border: 1px solid #dddddd;
    border-radius: 5px;
}

.single .tag-widget a:hover {
    color: #ffffff;
    background: #fbaf32;
    border-color: #fbaf32;
}

.sidebar .image-widget {
    display: block;
    width: 100%;
    overflow: hidden;
}

.sidebar .image-widget img {
    max-width: 100%;
    transition: .3s;
}

.sidebar .image-widget img:hover {
    transform: scale(1.1);
}


/*******************************/
/********* Contact CSS *********/
/*******************************/
.contact {
    position: relative;
    width: 100%;
    padding: 45px 0 15px 0;
}

.contact .contact-information {
    min-height: 150px;
    margin: 0 0 30px 0;
    padding: 30px 15px 0 15px;
    background: rgba(0, 0, 0, .04);
}

.contact .contact-info {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}

.contact .contact-icon {
    position: relative;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fbaf32;
    border-radius: 50px;
}

.contact .contact-icon i {
    font-size: 18px;
    color: #ffffff;
}

.contact .contact-text {
    position: relative;
    width: calc(100% - 50px);
    display: flex;
    flex-direction: column;
    padding-left: 15px;
}

.contact .contact-text h3 {
    font-size: 18px;
    font-weight: 700;
    color: #719a0a;
}

.contact .contact-text p {
    margin: 0;
    font-size: 16px;
    color: #454545;
}

.contact .contact-social a {
    margin-right: 10px;
    font-size: 18px;
    color: #fbaf32;
}

.contact .contact-social a:hover {
    color: #719a0a;
}

.contact .contact-form iframe {
    width: 100%;
    height: 380px;
    border-radius: 15px;
    margin-bottom: 25px;
}

.contact .contact-form input {
    padding: 15px;
    background: none;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, .1);
}

.contact .contact-form textarea {
    height: 150px;
    padding: 8px 15px;
    background: none;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, .1);
}

.contact .help-block ul {
    margin: 0;
    padding: 0;
    list-style-type: none;
}


/*******************************/
/********* Footer CSS **********/
/*******************************/
.footer {
    position: relative;
    margin-top: 45px;
    padding-top: 90px;
    background: rgba(0, 0, 0, .04);
}

.footer .footer-contact,
.footer .footer-link,
.footer .footer-newsletter {
    position: relative;
    margin-bottom: 45px;
    color: #454545;
}

.footer .footer-contact h2,
.footer .footer-link h2,
.footer .footer-newsletter h2 {
    position: relative;
    margin-bottom: 30px;
    padding-bottom: 10px;
    font-size: 22px;
    font-weight: 700;
    color: #fbaf32;
}

.footer .footer-contact h2::after,
.footer .footer-link h2::after,
.footer .footer-newsletter h2::after {
    position: absolute;
    content: "";
    width: 45px;
    height: 2px;
    bottom: 0;
    left: 0;
    background: #719a0a;
}

.footer .footer-link a {
    display: block;
    margin-bottom: 10px;
    color: #454545;
    transition: .3s;
}

.footer .footer-link a::before {
    position: relative;
    content: "\f105";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-right: 10px;
    color: #fbaf32;
}

.footer .footer-link a:hover {
    color: #fbaf32;
    letter-spacing: 1px;
}

.footer .footer-contact p i {
    width: 25px;
    color: #fbaf32;
}

.footer .footer-social {
    position: relative;
    margin-top: 20px;
    display: flex;
}

.footer .footer-social a {
    display: inline-block;
    margin-right: 5px;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fbaf32;
    border-radius: 35px;
    font-size: 16px;
    color: #ffffff;
}

.footer .footer-social a:hover {
    background: #719a0a;
}

.footer .footer-social a:last-child {
    margin: 0;
}

.footer .footer-newsletter .form {
    position: relative;
    width: 100%;
}

.footer .footer-newsletter input {
    height: 60px;
    background: transparent;
    border: 1px solid #fbaf32;
    border-radius: 5px;
}

.footer .footer-newsletter .btn {
    position: absolute;
    top: 8px;
    right: 8px;
    height: 44px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: 700;
}

.footer .copyright {
    position: relative;
    width: 100%;
    padding: 30px 0;
    text-align: center;
    background: #ffffff;
}

.footer .copyright p {
    margin: 0;
    display: inline-block;
    color: #454545;
}

.footer .copyright p a {
    color: #fbaf32;
}

.footer .copyright p a:hover {
    color: #719a0a;
}
.buttonabout {
    padding: 12px 25px;
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: white;
    background: #719a0a;
    border: 2px solid #719a0a;
    border-radius: 5px;
    transition: .5s;
}

.buttonabout:hover {
    color: black;
    background: transparent;
}
/* Loader styles */
.loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid #f3f3f3;
            border-top: 5px solid green;
            animation: spin 1s linear infinite;
            position: relative;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-family:monospace;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 24px;
            text-align: center;
        }

        /* Scrollbar Track */
::-webkit-scrollbar {
  width: 10px; /* Width of the scrollbar */
}

/* Scrollbar Handle */
::-webkit-scrollbar-thumb {
  background: #888; /* Color of the scrollbar handle */
  border-radius: 5px; /* Rounded corners */
}

/* Hover effect on scrollbar handle */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Scrollbar Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; /* Color of the scrollbar track */
  border-radius: 5px; /* Rounded corners */
}

/* Handle on the scrollbar while scrolling */
::-webkit-scrollbar-thumb:active {
  background: #333;
}
    </style>
    <body>
    <div class="loader-container">
        <div class="loading-text">Welcome!</div>
        <div class="spinner"></div>
    </div>
        <!-- Nav Bar Start -->
        <div class="navbar navbar-expand-lg bg-light navbar-light">
            <div class="container-fluid">
                <a href="userlandingpage.html" class="navbar-brand">Czyrahs <span>Pizza</span></a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="userlandingpage.php" class="nav-item nav-link active">Home</a>
                        <a href="menu.php" class="nav-item nav-link">Menu</a>
                        <a href="usercart.php" class="nav-item nav-link">Cart</a>
                        <a href="userordering.php" class="nav-item nav-link">Orders</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Profile</a>
                            <div class="dropdown-menu">
                                <a href="userprofile.php" class="dropdown-item">Settings</a>
                                <a href="recentorder.php" class="dropdown-item">Recent</a>
                                <a href="feedback.php" class="dropdown-item">Feedbacks</a>
                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Nav Bar End -->


        <!-- Carousel Start -->
        <div class="carousel">
            <div class="container-fluid">
                <div class="owl-carousel">
                    <div class="carousel-item">
                        <div class="carousel-img">
                            <img src="img/carousel-2.jpg" alt="Image">
                        </div>
                        <div class="carousel-text">
                            <h1>Best <span>Quality</span> Ingredients</h1>
                            <p>
                                Consists of our Cheese that instantly melts in your mouth!
                            </p>
                            <div class="carousel-btn">
                                <a class="btn custom-btn" href="menu.php">View Menu</a>
                                <a class="btn custom-btn" href="usercart.php">View Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-img">
                            <img src="img/carousel-1.jpg" alt="Image">
                        </div>
                        <div class="carousel-text">
                            <h1>Manila's <span>Best</span> Pizza</h1>
                            <p>
                                Can be seen in the streets and be bought only in cheap prices!
                            </p>
                            <div class="carousel-btn">
                                <a class="btn custom-btn" href="menu.php">View Menu</a>
                                <a class="btn custom-btn" href="usercart.php">View Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-img">
                            <img src="img/carousel-3.jpg" alt="Image">
                        </div>
                        <div class="carousel-text">
                            <h1>Fastest Order <span>Delivery</span></h1>
                            <p>
                                Order Now we Knock Later~
                            </p>
                            <div class="carousel-btn">
                                <a class="btn custom-btn" href="menu.php">View Menu</a>
                                <a class="btn custom-btn" href="usercart.php">View Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div class="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-img">
                            <img src="img/about1.jpg" alt="Image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="section-header">
                                <p>About Us</p>
                                <h2>Cooking Since 2013</h2>
                            </div>
                            <div class="about-text">
                                <p>
                                    We make our 'Pizza' improve more and taste better throughout Generation because of our Cheesylicious Pizza we make
                                </p>
                                <p>
                                    Furthermore any other ingredients made with love and homemade to ensure our customer best selling taste!
                                </p>
                                <a class="buttonabout" href="menu.php">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
        
        
        <!-- Feature Start -->
        <div class="feature">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="section-header">
                            <p>Why Choose Us</p>
                            <h2>Our Key Features</h2>
                        </div>
                        <div class="feature-text">
                            <div class="feature-img">
                                <div class="row">
                                    <div class="col-6">
                                        <img src="img/pizzafeat1.jpg" alt="Image">
                                    </div>
                                    <div class="col-6">
                                        <img src="img/pizzafeat2.jpg" alt="Image">
                                    </div>
                                    <div class="col-6">
                                        <img src="img/pizzafeat3.jpg" alt="Image">
                                    </div>
                                    <div class="col-6">
                                        <img src="img/pizzafeat4.jpg" alt="Image">
                                    </div>
                                </div>
                            </div>
                            <p>
                                Handmade and Freshly Made by our Chef's that will fulfill your tasteful desires in the Pizza we made!
                            </p>
                            <a class="btn buttonabout" href="menu.php">View Menu</a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="feature-item">
                                    <i class="flaticon-cooking"></i>
                                    <h3>Newly Cooked Pizza</h3>
                                    <p>
                                        Eventhough it's Newly made it's instantly served too!
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="feature-item">
                                    <i class="flaticon-vegetable"></i>
                                    <h3>Natural ingredients</h3>
                                    <p>
                                        Ingredients that never be more and never been less but purely balanced.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="feature-item">
                                    <i class="flaticon-medal"></i>
                                    <h3>Best Quality Products</h3>
                                    <p>
                                        99% Served without germs and any bacteria that can harm the customer!
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="feature-item">
                                    <i class="flaticon-meat"></i>
                                    <h3>Fresh vegetables & Meet</h3>
                                    <p>
                                        We serve to be Served by our valued everlasting customer so do you~
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="feature-item">
                                    <i class="flaticon-courier"></i>
                                    <h3>Fastest door delivery</h3>
                                    <p>
                                        You Order we Knock Later so you can more Happier!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->
        
        
        <!-- Food Start -->
        <div class="food">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="food-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M9.76 2.021a.995.995 0 0 0-.989.703L3.579 19.166a1 1 0 0 0 1.255 1.255l16.442-5.192a.991.991 0 0 0 .702-.988C21.6 7.666 16.334 2.4 9.76 2.021zM10 16a2 2 0 1 1 .001-4.001A2 2 0 0 1 10 16zm6-2a2 2 0 1 1 .001-4.001A2 2 0 0 1 16 14z"></path></svg>
                            <h2>Pizza</h2>
                            <p>
                                Cheesiest Pizza you will taste and Mouthful taste of side ingredients.
                            </p>
                            <a href="menu.php">View Menu</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="food-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="m21.88 2.15-1.2.4a13.84 13.84 0 0 1-6.41.64 11.87 11.87 0 0 0-6.68.9A7.23 7.23 0 0 0 3.3 9.5a8.65 8.65 0 0 0 1.47 6.6c-.06.21-.12.42-.17.63A22.6 22.6 0 0 0 4 22h2a30.69 30.69 0 0 1 .59-4.32 9.25 9.25 0 0 0 4.52 1.11 11 11 0 0 0 4.28-.87C23 14.67 22 3.86 22 3.41zm-7.27 13.93c-2.61 1.11-5.73.92-7.48-.45a13.79 13.79 0 0 1 1.21-2.84A10.17 10.17 0 0 1 9.73 11a9 9 0 0 1 1.81-1.42A12 12 0 0 1 16 8V7a11.43 11.43 0 0 0-5.26 1.08 10.28 10.28 0 0 0-4.12 3.65 15.07 15.07 0 0 0-1 1.87 7 7 0 0 1-.38-3.73 5.24 5.24 0 0 1 3.14-4 8.93 8.93 0 0 1 3.82-.84c.62 0 1.23.06 1.87.11a16.2 16.2 0 0 0 6-.35C20 7.55 19.5 14 14.61 16.08z"></path></svg>
                            <h2>Sauces</h2>
                            <p>
                                Pizza isn't complete with these so we add some free for our customers
                            </p>
                            <a href="menu.php">View Menu</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="food-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path></svg>
                            <h2>Package Quality</h2>
                            <p>
                                When Delivering we assure pizza is maintained!
                            </p>
                            <a href="menu.php">View Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Food End -->
        
        
        <!-- Menu Start -->
        <div class="menu">
            <div class="container">
                <div class="section-header text-center">
                    <p>Food Menu</p>
                    <h2>Delicious Food Menu</h2>
                </div>
                <div class="menu-tab">
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#burgers">Pizza's</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="burgers" class="container tab-pane active">
                            <div class="row">
                                <div class="col-lg-7 col-md-12">
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <img src="img/menu-pizza.jpg" alt="Image">
                                        </div>
                                        <div class="menu-text">
                                            <h3><span>Ham & Cheese Pizza</span> <strong>75.00 php</strong></h3>
                                            <p>Our Specialty Pizza and Best Selling!</p>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <img src="img/menu-hawaiian.jpg" alt="Image">
                                        </div>
                                        <div class="menu-text">
                                            <h3><span>Hawaiian Pizza</span> <strong>85.00 php</strong></h3>
                                            <p>Need Pineapple No Problem we got you covered~</p>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <img src="img/menu-bacon.jpg" alt="Image">
                                        </div>
                                        <div class="menu-text">
                                            <h3><span>Bacon Pizza</span> <strong>95.00 php</strong></h3>
                                        <p>More Ingredients more the Fun! Plus the Taste!</p>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <img src="img/menu-pepperoni.jpg" alt="Image">
                                        </div>
                                        <div class="menu-text">
                                            <h3><span>Pepperoni Pizza</span> <strong>85.00 php</strong></h3>
                                            <p>Delightful Pepperoni to enjoy your day!</p>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <img src="img/menu-vegetarian.jpg" alt="Image">
                                        </div>
                                        <div class="menu-text">
                                            <h3><span>Vegetarian Pizza</span> <strong>85.00 php</strong></h3>
                                            <p>Healthy packed Vegies for your diet!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-none d-lg-block">
                                    <img src="img/pizza (1).png" alt="Image">
                                </div>
                            </div>
                        </div>
                        
        <!-- Menu End -->
        
        
        
                                <!-- Footer Start -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="company-name">All Rights Reserved. &copy; 2023 <a href="#">Czyrah's Pizza</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->       

        <!-- Footer End -->

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        
        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>window.addEventListener('load', function() {
            const spinner = document.querySelector('.spinner');
            const loadingText = document.querySelector('.loading-text');
            setTimeout(() => {
                let opacity = 1;
                let fadeOutInterval = setInterval(() => {
                    opacity -= 0.1;
                    spinner.style.opacity = opacity;
                    loadingText.style.opacity = opacity;
                    if (opacity <= 0) {
                        clearInterval(fadeOutInterval);
                        document.querySelector('.loader-container').style.display = 'none';
                    }
                }, 50);
            }, 500);
        });</script>
    </body>
</html>
