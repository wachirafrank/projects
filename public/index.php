<?php
function loadTemplate($templateFileName, $variables = []){
  extract($variables);

  ob_start();
  include __DIR__ . '/../templates/'. $templateFileName;
  return ob_get_clean();
}
try {
  include __DIR__ . '/../includes/DatabaseConnection.php';
  include __DIR__ . '/../classes/DatabaseTable.php';
  include __DIR__ . '/../classes/controllers/JokeController.php';

  $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
  $authorsTable = new DatabaseTable($pdo, 'author', 'id');
  $jokeController = new JokeController($jokesTable, $authorsTable);

  $action = $_GET['action'] ?? 'home';
  if($action == strtolower($action)){
    $page = $jokeController->$action();
  } else {
    http_response_code( 301);
    header('location:index.php?action=' . strtolower($action));
  }


  $title = $page['title'];
  // check to see if $page['variables'] is set because not all methods in the JokeController set it.
  // e.g if $page['variables'] comes from the list method, $variables called $totalJokes and $jokes will be created
  if(isset($page['variables'])){
    $output = loadTemplate($page['template'], $page['variables']);
  } else {
    $output = loadTemplate($page['template']);
  }
  // ob_start();
  // include __DIR__ . '/../templates/' . $page['template'];
  // $output = ob_get_clean();

} catch (PDOException $e) {
  $title = 'An Error Occured';
  $output = 'Database Error:'.  $e->getMessage() . 'in'. $e->getFile(). ':'. $e->getLine();
}
include __DIR__ . '/../templates/layout.html.php';
