<?php
require_once "const.php";
require_once "db.php";
require_once "auth.php";
require_once "utils.php";
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?= $title ?? "Školská jedáleň" ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  <?php $loginmsg = authentificate(); ?>
  <header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
      <a class="navbar-brand" href=".">Školská jedáleň</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item<?=menu_active_class('index')?>">
            <a class="nav-link" href=".">Jedálny lístok<?=menu_active_sr('index')?></a>
          </li>
          <?php if(isLoggedIn()): ?>
          <li class="nav-item<?=menu_active_class('history')?>">
            <a class="nav-link" href="history.php">História transakcií<?=menu_active_sr('history')?></a>
          </li>
      <?php endif; ?>
        </ul>
        <?php if(!isLoggedIn()): ?>
        <form class="form-inline mr-3" method="POST">
	    	<input name="username" class="form-control mr-sm-2" type="text" placeholder="pouzivatelskemeno" aria-label="Používateľské meno" value="<?=$_POST['username']?>">
	    	<input name="password" class="form-control mr-sm-2" type="password" placeholder="heslo" aria-label="Používateľské heslo" value="<?=$_POST['password']?>">
	    	<button class="btn btn-outline-light my-2 my-sm-0" type="submit" value="login" name="action">Prihlásiť sa</button>
	  	</form>
	  <?php else: ?>
	  	<form class="form-inline mr-3" method="POST">
	    	<button class="btn btn-outline-light my-2 my-sm-0" type="submit" value="logout" name="logout">Odhlásiť sa</button>
	  	</form>
	  <?php endif; ?>
	  <?php if(isLoggedIn()): ?>
        <span class="navbar-text">
          Stav účtu: <b><?=$currentBalance?>€</b>
        </span>
        <?php endif; ?>
      </div>
    </nav>
  </header>
<?php if($loginmsg) echo '<section class="container">' . $loginmsg . '</section>'; ?>



