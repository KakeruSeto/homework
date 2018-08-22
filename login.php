<?php
  session_start();
  require_once('./functions.php');

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $passwd = $_POST['passwd'];

  if (empty($username) || empty($passwd)){
    $_SESSION["error"] = "入力されてない項目があります";
    header("Location: login.php");
    return;
  }

  $pdo = connectDB();
  $sql = "SELECT * FROM b_users WHERE username = :username";
  $statement = $pdo->prepare($sql);
  $statement->execute([
    ':username' => $username,
  ]);
  $user = $statement->fetch();

  if (!$user) {
    $_SESSION["error"] = "ユーザ名に誤りがあります。";
    header("Location: login.php");
    return;
  }

  if (!password_verify($passwd,$user['passwd']))  {
    $_SESSION["error"] = "パスワードに誤りがあります。";
    header("Location: login.php");
    return;
  }

  $_SESSION["user"]["id"] = $user['id'];
  $_SESSION["user"]["username"] = $user['username'];
  $_SESSION["success"] = "ログインしました。";
  header("Location: mypage.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
          <a class="logo">BLANCIEL Knowledge</a>
        </div>
        <div class="header-right">
          <a href="./new_user.php" class="login"> 新規登録</a>
        </div>
      </div>
    </header>

    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <pre><?php echo $_SESSION['success']; ?></pre>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($_SESSION['error'])): ?>
        <div>
            <pre><?php echo $_SESSION['error']; ?></pre>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>

    <div class="top-wrapper">
      <div class="container">
        <h1>BLANCIEL Knowledge</h1>
        <h2>ログイン!</h2>
        <form action="" method="POST">
          <div>
              <label for="username-input">ユーザー名</label>
              <input type="text" name="username" id="username-input" placeholder="">
          </div>
          <div>
              <label for="password-input">パスワード</label>
              <input type="password" name="passwd" id="password-input" placeholder="">
          </div>
          <input type="submit" value="ログイン" class="btn signup">
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
