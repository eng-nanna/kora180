<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كورة 180 | <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/fonts/opensans_regular/stylesheet.css" />
    <link rel="stylesheet" href="css/fonts/opensans_bold/stylesheet.css" />
    <link rel="stylesheet" href="css/fontawesome-all.css" />
    <link rel="stylesheet" href="css/style.css" />

    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <style>
        .back-link{
            color: #1B5E20;
            font-size: medium;
            display: inline-block;
            padding-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="row">
    <!-- nav section -->
    <div class="medium-3 column subMenuContainer">
        <div class="logo-container">
            <a href="#"><img src="img/kora.jpg" alt=""></a>
        </div>
        <nav>
            <ul class="menu vertical sideSubMenu">
                <li>
                    <a href="home.php"> <i class="fas fa-lock"></i> <span>الأدمن</span> </a>
                </li>
                <li>
                    <a href="leagues.php"> <i class="far fa-futbol"></i> <span>الدوريات</span> </a>
                    <ul class="menu vertical">
                        <li><a href="leagues.php">الدوريات</a></li>
                        <li><a href="teams.php">الفرق</a></li>
                        <li><a href="matches.php">المباريات</a></li>
                    </ul><!-- submenu -->
                </li>

                <li><a href="news.php"><i class="fas fa-newspaper"></i><span>الأخبار</span></a></li>
                <li><a href="bloggers.php"><i class="fas fa-file-alt"></i><span>آراء حرة</span></a></li>
                <li><a href="videos.php"><i class="fas fa-video"></i><span>فيديو</span></a>
                    <ul class="menu vertical">
                        <li><a href="categories.php">تصنيفات</a></li>
                        <li><a href="videos.php">فيديو</a></li>
                    </ul><!-- submenu -->
                </li>
            </ul>
        </nav>
    </div><!-- subMenu -->
    <!-- ==== end nav ===== -->

    <!-- ==== Modules Contaner ==== -->
    <div class="medium-9 column moduleContainer">
        <div class="headerBtns">
            <a href="#" class="button">logout</a>
        </div>