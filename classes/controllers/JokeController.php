<?php
class JokeController {
  private $authorsTable;
  private $jokesTable;

  public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable){
    $this->jokesTable = $jokesTable;
    $this->authorsTable = $authorsTable;
  }

  public function list(){
    $result = $this->jokesTable->findAll();
    foreach ($result as $joke) {
      $author = $this->authorsTable->findById($joke['authorId']);
      $jokes[]  = [
        'id' => $joke['id'],
        'jokedate'=>$joke['jokedate'],
        'joketext' => $joke['joketext'],
        'name' => $author['name'],
        'email'=>$author['email']
      ];
    }
    $title = 'Jokes List';
    $totalJokes = $this->jokesTable->total();

    // ob_start();
    // include __DIR__ . '/../templates/jokes.html.php';
    // $output = ob_get_clean();
    return ['template' => 'jokes.html.php', 'title' => $title, 'variables' => ['totalJokes' => $totalJokes, 'jokes' => $jokes]];
  }

  public function home(){
    $title = 'Internet Joke Database';
    // ob_start();
    // include __DIR__ . '/../templates/home.html.php';
    // $output = ob_get_clean();
    return ['template' => 'home.html.php', 'title' => $title];
  }

  public function delete(){
    $this->jokesTable->delete($_POST['id']);
    header('location:index.php?action=list');

    return ['output' => $output, 'title' => $title];
  }

  public function edit(){
    if(isset($_POST['joke'])){
      // $joke array will contain <from editjoke.html.php form i.e joke[id], joke[joketext]>
      $joke = $_POST['joke'];
      // plus the ones that don't come from the form
      $joke['jokedate'] = new DateTime();
      $joke['authorId'] = 1;

      $this->jokesTable->save($joke);
      header('location:index.php?action=list');
    } else {
      if(isset($_GET['id'])){
        $joke = $this->jokesTable->findById($_GET['id']);
      }
      $title = 'Edit Joke';
      // ob_start();
      // include __DIR__ . '/../templates/editjoke.html.php';
      // $output = ob_get_clean();
      return ['template' => 'editjoke.html.php', 'title' => $title, 'variables' => ['joke' => $joke ?? null]];
      }
  }
}
