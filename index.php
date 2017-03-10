<?php
  require_once 'lib/Twig/Autoloader.php';
  Twig_Autoloader::register();
  require_once 'api/proposals.php';

  $loader = new Twig_Loader_Filesystem('templates');

  $twig = new Twig_Environment($loader, array('cache' => 'compilation_cache', 'debug' => true, 'auto_reload' => true));

  $twig->addGlobal('isLoggedIn', false);

  session_start();
  define('ROOTPATH', __DIR__);

  $currentPage = isset($_GET['page']) ? $_GET['page'] : 'main';

  if (isset($_SESSION['username'])) {
      $twig->addGlobal('isLoggedIn', true);
  }

  switch ($currentPage) {
    case 'main':
        echo $twig->render('main.twig', array("AcceptedProposals" => getAcceptedProposals()));
        break;
    case 'admin':
        echo $twig->render('admin.twig', array("WaitingProposals" => getWaitingProposals()), isLoggedIn);
        break;
    default:
        echo $twig->render('main.twig', array("AcceptedProposals" => getAcceptedProposals()));
        break;
}

?>
