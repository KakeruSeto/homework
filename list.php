<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id=$_POST['id'];
    $sql = "DELETE FROM b_articles WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
    ':id'=>$id,
  ]);
      header("Location: mypage.php");
}
  $sql2 ="SELECT * FROM b_articles  WHERE user_id =:target_user_id";
  $statement = $pdo->prepare($sql2);
    $statement->execute([
      ':target_user_id' => $id,
    ]);
  $articles = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>一覧</title>
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
          <h2>一覧</h2>
        <?php foreach($articles as $article): ?>
            <p><a href="./article.php?id=<?php echo $article['id']; ?>"><?php echo h($article['title']); ?><form action='' method='post'>
            <input type ="hidden"name="id"value="<?php echo $article['id']?>">
            <input type="submit" value="削除"class="btn signup">
      　　  </form></a>
            </p>
          </p>
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
