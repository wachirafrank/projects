<?php
// private means can only be accessed/called by another memmber(method) inside class
class EntryPoint {
  private $route; //the route to add, a single url var containing e.g 'joke/home' that triggers a specific controller action

  public __construct($route){
    $this->route = $route;
    //invoke checkUrl() here ensuring $controller and $action  are lowercase
  }

  private checkUrl(){
    //is the supplied route equal to its lowercase version, if not ...
    if($this->route !== strtolower($this->route)){
      // redirect user to lowercase version
      http_response_code( 301);
      header('location' . strtolower($this->route))
    }
  }
  //takes care of loading a template
  private function loadTemplate($templateFileName, $variables = []){
    extract($variables);

    ob_start();
    include __DIR__ . '/../templates' . $templateFileName;
    return ob_get_clean();

  }
  // call the relevant controller $ controller action based on route, and return th $page var;
  private callAction(){
      include __DIR__  . '/../classes/DatabaseTable';
      include __DIR__ . '/../includes/DatabaseConnection.php';

      $jokesTable = new DatabaseTable($pdo,'joke','id');
      $jokesTable = new DatabaseTable($pdo,'author','id');

      if($this->route === 'joke/list'){
        include __DIR__ . '/../classes/controllers/JokeController.php';
      }
  }
}
