<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="jokes.css">
    <title><?=$title ?></title>
  </head>
    <nav>
      <header>
        <h1>Internet Joke Db</h1>
      </header>
      <ul>
        <li><a href="index.php?">Home</a></li>
        <li><a href="index.php?action=list">Joke List</a></li>
        <li><a href="index.php?action=edit">Add a new Joke</a></li>
      </ul>
    </nav>
    <main>
      <?=$output ?>
    </main>
    <footer>
      &copy; IJDB 2019
    </footer>
  </body>
</html>
