<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pagina de Inicio</title>
        <meta name="description" content="Default Description" />
        <meta name="keywords" content="Magento, Varien, E-commerce" />
        <meta name="robots" content="*" />
        <link rel="icon" href="magento/skin/frontend/default/default/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="magento/skin/frontend/default/default/favicon.ico" type="image/x-icon" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script type="text/javascript" src="media/js/jcarousel.js"></script>
        <link href="media/css/jcarousel.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
            <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script type="text/javascript">// <![CDATA[

            $(document).ready(function() {
                $('#mycarousel').jcarousel({
                    wrap: 'circular',
                    visible: 4

                });
                $('.atletas').hover(function(){
                    $('.subAtletas').slideToggle("slow");
                });
            });
            
        // ]]></script>
        <!--[if lt IE 7]>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="media/css/styles.css" media="all" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="magento/skin/frontend/default/default/css/styles-ie.css" media="all" />
        <![endif]-->
        <!--[if lt IE 7]>
        <script type="text/javascript" src="magento/js/lib/ds-sleight.js"></script>
        <script type="text/javascript" src="magento/skin/frontend/base/default/js/ie6.js"></script>
        <![endif]-->

    </head>
    <body class=" cms-index-index cms-home">
        <div class="wrapper">
            <noscript>
                <div class="global-site-notice noscript">
                    <div class="notice-inner">
                        <p>
                            <strong>JavaScript seems to be disabled in your browser.</strong><br />
                            You must have JavaScript enabled in your browser to utilize the functionality of this website.                </p>
                    </div>
                </div>
            </noscript>
            <div class="page">
                <div class="header-container">
                    <div class="header">
                        <h1 class="logo"><strong>Magento Commerce</strong><a href="" title="Magento Commerce" class="logo"><img src="media/img/logo.gif" alt="Magento Commerce" /></a></h1>
                        <div class="quick-access">
                            <form id="search_mini_form" action="magento/index.php/catalogsearch/result/" method="get">
                                <div class="form-search">
                                    <label for="search">Search:</label>
                                    <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" />
                                    <button type="submit" title="Search" class="button"><span><span>Search</span></span></button>
                                    <div id="search_autocomplete" class="search-autocomplete"></div>
                                </div>
                            </form>
                            <p class="welcome-msg">Default welcome msg! </p>
                            <ul class="links">
                                <li class="first" ><a href="magento/index.php/customer/account/" title="My Account" >My Account</a></li>
                                <li ><a href="magento/index.php/wishlist/" title="My Wishlist" >My Wishlist</a></li>
                                <li ><a href="magento/index.php/checkout/cart/" title="My Cart" class="top-link-cart">My Cart</a></li>
                                <li ><a href="magento/index.php/checkout/" title="Checkout" class="top-link-checkout">Checkout</a></li>
                                <li class=" last" ><a href="magento/index.php/customer/account/login/" title="Log In" >Log In</a></li>
                            </ul>
                        </div>
                        <ul class="botonera">
                            <li class="last privacy <?= (($active == 'index')?'active':'')?>" onclick='document.location="index.php"'>HOME</li>
                            <li class="last atletas privacy <?= (($active == 'atletas')?'active':'')?>">
                                ATLETAS 
                                <ul class="subAtletas">
                                    <li onclick='document.location="atletas.php"'>APOIOS</li>
                                    <li onclick='document.location="atletasP.php"'>PATROCINIO</li>
                                </ul>
                            </li>
                            <li class="last privacy">PRODUTOS</li>
                            <li class="last privacy <?= (($active == 'sobre')?'active':'')?>" onclick='document.location="sobre.php"'>SOBRE A SK81</li>
                            <li class="last privacy <?= (($active == 'contacto')?'active':'')?>" onclick='document.location="contacto.php"'>CONTATO</li>
                            <li class="last privacy <?= (($active == 'loja')?'active':'')?>" onclick='document.location="lojaFisica.php"'>LOJA FISICA</li>
                            <li class="last privacy">BLOG</li>
                        </ul>
                    </div>
                </div>