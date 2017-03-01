<?php
  require_once 'lib/Twig/Autoloader.php';
  Twig_Autoloader::register();

  $loader = new Twig_Loader_Filesystem('templates');

  $twig = new Twig_Environment($loader, array('cache' => 'compilation_cache', 'debug' => true, 'auto_reload' => true));

  $twig->addGlobal('isLoggedIn', false);

  echo $twig->render('main.twig');
?>
