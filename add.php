<?php
  require_once('./functions.php');
  session_start();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $tag = $_POST['tag'];

     $sql = "INSERT INTO tag(tag)
      VALUES(:tag)";
     $statement = $pdo->prepare($sql);
     $result = $statement->execute([
       ':tag'=>$tag,
       ]);
       header("Location: mypage.php");
   }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>タグの追加</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
          <a class="logo">BLANCIEL Knowledge</a>
        </div>
        <div class="header-right">
          <a href="./logout.php" class="login">ログアウト</a>
        </div>
        <div class="header-right">
          <a href="./create.php" class="login">作成</a>
        </div>
        <div class="header-right">
          <a href="./add.php" class="login">タグの追加</a>
        </div>
        <div class="header-right">
          <a href="./list.php" class="login">一覧</a>
        </div>
        <div class="header-right">
         <a href="./mypage.php" class="login">マイページ</a>
        </div>
      </div>
    </header>
    <div class="top-wrapper">
      <div class="container">
        <form action="" method="post">
          <p>
              <input type="text" name="tag">
              <input type="submit" value="追加" class="btn signup">
          </p>
        </form>
      </div>
    </div>
    <footer>
      <div class="container">
        <p>BLANCIEL Knowledge</p>
      </div>
    </footer>
  </body>
</html>
