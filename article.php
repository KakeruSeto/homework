<?php
  require_once('./functions.php');
  session_start();
  $article_id = $_GET['id'];
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $nichiji  = date('Y-m-d H:i:s');
  $pdo = connectDB();

  $sql = "SELECT b_articles.id,b_articles.title,b_articles.body,b_articles.created_at from b_articles where b_articles.id = '$article_id'";
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $article = $statement->fetch();

  $sql2 = 'SELECT * FROM b_users WHERE id = :user_id';
  $statement = $pdo->prepare($sql2);
  $statement->execute([':user_id' => $user_id]);
  $result = $statement->fetch();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

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
        <h3>作成者：<?php echo h($result['username']); ?></h3>
        <p>内容：<?php echo h($article['body']); ?></p>
        <form action="article.php" method="post">
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
