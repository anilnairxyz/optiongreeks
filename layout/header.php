<!DOCTYPE html>
<html lang="en">
  <head>

    <!--Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Title-->
    <?php $sitename="Option Greeks";?>
    <?php $root="/greeks/";?>
    <title><?php echo $sitename?></title>
    <meta name="description" content="Option Price, Implied Volatility and Option Greeks">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">
    <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="img/favicon.ico">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-config" content="img/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script type="text/javascript">
       WebFontConfig = {
         google: { families: [ 'Montserrat', 'Anton', 'Fjalla+One' ] }
       };
       (function() {
         var wf = document.createElement('script');
         wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
           '://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
         wf.type = 'text/javascript';
         wf.async = 'true';
         var s = document.getElementsByTagName('script')[0];
         s.parentNode.insertBefore(wf, s);
       })();
    </script>
    <script type="text/javascript">
       let mainNav = document.getElementById('js-menu');
       let navBarToggle = document.getElementById('js-navbar-toggle');
       navBarToggle.addEventListener('click', function () {
         mainNav.classList.toggle('show_navbar');
       });
    </script>
  </head>

  <body>
    <div class="notice">Your browser doesn't support CSS Grid Layout. Unfortunately, you won't be able to view this website.
    </div>
    <div id="container">
      <header>
        <nav class="navbar">
          <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fa fa-bars"></i>
          </span>
          <a href="#" class="logo"><img src="img/main_logo.svg" alt="&pi;/4"></a>
          <ul class="main-nav" id="js-menu">
            <li>
			<?php if ($page == "opprice") { ?>
			  <a href=<?php echo $root ?> class="nav-links active">Option Price</a>
			<?php } else { ?>
			  <a href=<?php echo $root ?> class="nav-links">Option Price</a>
			<?php } ?>
            </li>

            <li>
			<?php if ($page == "iv-calc") { ?>
			  <a href=<?php echo $root."iv-calc.php" ?> class="nav-links active">Implied Volatility</a>
			<?php } else { ?>
			  <a href=<?php echo $root."iv-calc.php" ?> class="nav-links">Implied Volatility</a>
			<?php } ?>
            </li>
            <li>
			<?php if ($page == "payoff") { ?>
			  <a href=<?php echo $root."payoff.php" ?> class="nav-links active">Payoff</a>
			<?php } else { ?>
			  <a href=<?php echo $root."payoff.php" ?> class="nav-links">Payoff</a>
			<?php } ?>
            </li>
            <li>
			<?php if ($page == "compare") { ?>
			  <a href=<?php echo $root."compare.php" ?> class="nav-links active">Compare</a>
			<?php } else { ?>
			  <a href=<?php echo $root."compare.php" ?> class="nav-links">Compare</a>
			<?php } ?>
            </li>
          </ul>
        </nav>
      </header>
