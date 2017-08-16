<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="" <?php language_attributes(); ?>>
<!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width" initial-scale="1">
    <title>
        <?php wp_title('&laquo;', true, 'right'); ?>
        <?php bloginfo('name'); ?>
    </title>

    <!-- Main WordPress Stylesheet -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <!-- WYSIWYG CSS -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/wysiwyg.css" type="text/css" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link href="<?php bloginfo('stylesheet_directory'); ?>/responsive/boilerplate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/custom.css" type="text/css" media="screen" />
    <link href="<?php bloginfo('stylesheet_directory'); ?>/css/normalize.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-ui-1.8.18.custom.min.js"></script>
    <!--
    To learn more about the conditional comments around the html tags at the top of the file:
    paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

    Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
    * insert the link to your js here
    * remove the link below to the html5shiv
    * add the "no-js" class to the html tags at the top
    * you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build
    -->
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php bloginfo('stylesheet_directory'); ?>/responsive/respond.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script  src="https://cdn.rawgit.com/JDMcKinstry/JavaScriptDateFormat/master/Date.format.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/myjs.js"></script>

    <?php  wp_head(); ?>
    <link href="<?php bloginfo('stylesheet_directory'); ?>/css/datepicker.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="gridContainer clearfix" id="e3ve-gridContainer">
    <div id="primary-nav" style="width: 1064px; margin: 0px auto; padding: 0px; font-size: 10px; background-color: rgb(70, 70, 70); display:none;">
        <div id="inner-wrapper" style="padding:0; width:100%;">
            <ul style="margin:0 auto; padding:5px 0; list-style:none; display:block; float:right;">
                <li style="display:table-cell;"><a href="#" style="display:inline-block; color:#fff; text-decoration:none; text-transform:uppercase; padding:0 20px;">Home</a></li>
                <li style="display:table-cell; border-left:1px solid;"><a href="#" style="display:inline-block; color:#fff; text-decoration:none; text-transform:uppercase; padding:0 20px;">About Us</a></li>
                <li style="display:table-cell; border-left:1px solid;"><a href="#" style="display:inline-block; color:#fff; text-decoration:none; text-transform:uppercase; padding:0 20px;">Your Own Page</a></li>
                <li style="display:table-cell; border-left:1px solid;"><a href="#" style="display:inline-block; color:#fff; text-decoration:none; text-transform:uppercase; padding:0 20px;">Login</a></li>
            </ul>
        </div>
    </div>
    <div id="header">
        <div id="inner-wrapper">
            <div id="header-banner">
                <div class="hb-1"> <img src="https://bookphonecall.com/wp-content/uploads/2017/01/phone-icon.png" alt="icon" width="100" height="100"> </div>
                <div class="hb-2">
                    <h1>BookPhoneCall.com</h1>
                    <p>save time, avoid phone tag &amp; be more productive</p>
                </div>
                <div class="hb-3">
                    <p>What is this website?</p>
                    <a href="#"><img src="https://bookphonecall.com/wp-content/uploads/2017/01/header-vid1.png" alt="video" width="143" height="82"></a> </div>
            </div>
            <div class="header-right">
                <p>Request <span style="color:#65FF00">FREE</span> Call Backs from…</p>
                <div class="header-right-bullets">
                    <ul>
                        <li>Businesses</li>
                        <li>Suppliers</li>
                        <li>Organisations</li>
                        <li>Individuals</li>
                        <li>Want Your Own Page?</li>
                    </ul>
                    <div class="header-right-btn"><a href="#">details &gt;</a></div>
                </div>
            </div>
        </div>
    </div>
