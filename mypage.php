<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  $sql = "SELECT * FROM b_articles inner join b_users on b_articles.user_id=b_users.id";
  $statement = $pdo->prepare($sql);
    $statement->execute([
      ':target_user_id' => $id,
    ]);
  $articles = $statement->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>BLANCIEL Knowledge</title>
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
        <h1>BLANCIEL Knowledge</h1>
        <table>
          <thead>
            <tr>
              <h2>一覧</h2>
            </tr>
          </thead>
          <tbody>
            <?php foreach($articles as $article): ?>
              <tr>
                <p><a href="./article.php?id=<?php echo $article['id']; ?>">
                  <?php
                   echo ($article['title']);
                   echo ($article['created_at']);
                   echo ($article['user_id']);
                   echo ($article['username']);
                  ?></a></p>
              </tr>
            <?php endforeach; ?>
          </tbody>
       </table>
      </div>
    </div>
    <footer>
      <div class="container">
        <p>BLANCIEL Knowledge</p>
      </div>
    </footer>
  </body>
</html>
