<?php
  require_once('./functions.php');
  session_start();
  $id = $_GET['id'];
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  $sql = 'SELECT b_articles.id,b_articles.title,b_articles.body,b_articles.created_at from b_articles where articles_p.id = :id';
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $_GET['id']]);
  $article = $statement->fetch();
  $user_id = $article['user_id'];

  $sql2 = 'SELECT * FROM users_p WHERE id = :user_id';
  $statement = $pdo->prepare($sql2);
  $statement->execute([':user_id' => $user_id]);
  $result = $statement->fetch();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql3 = "INSERT INTO application(article_id,Application_user_id) VALUES(:article_id,:Application_user_id)";
    $statement = $pdo->prepare($sql3);
    $result = $statement->execute([
      ':article_id' => $_POST['id'],
      ':Application_user_id' => $id,
    ]);
    header("Location: mypage.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>詳細</title>
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
        <h1>詳細</h1>
        <h2>タイトル：<?php echo h($article['title']); ?></h2>
        <h3>応募者：<?php echo h($result['username']); ?></h3>
        <p>内容：<?php echo h($article['body']); ?></p>
        <form action="article.php" method="post">
          <p></p>
          <p></p>
          <p></p>
          <h3>この記事を編集しますか？</h3>
          <input type="hidden"name="id"value="<?php echo $article['id'];?>">
          <input type="submit" value="編集" class="btn signup">
        </form>
        <link rel="stylesheet" href="./stylesheet.css">
    </head>
    <body>
    <footer>
      <div class="container">
        <p>BLANCIEL Knowledge</p>
      </div>
    </footer>
  </body>
</html>
