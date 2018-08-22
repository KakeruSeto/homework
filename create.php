<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $nichiji  = date('Y-m-d H:i:s');
  $pdo = connectDB();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $tags = $_POST['tags'];


    $sql = "INSERT INTO b_articles (user_id, title,body,created_at,modified_at) VALUES(:user_id, :title,:body,:created_at,:modified_at)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
      ':user_id' => $id,
      ':title' => $title,
      ':body' => $body,
      ':created_at' => $nichiji,
      ':modified_at' => $nichiji,
    ]);

    $sql2 = "SELECT * FROM  b_articles where title ='".$title."'";
    $statement2 = $pdo->prepare($sql2);
    $statement2->execute();
    $article =$statement2->fetch(PDO::FETCH_ASSOC);

    foreach($tags as $tag){
    $sql3 = "INSERT INTO b_articles_tag (article_id,tag_id) VALUES(:article_id,:tag_id)";
    $statement = $pdo->prepare($sql3);
    $result = $statement->execute([
      ':article_id' => $article["id"],
      ':tag_id' => $tag,
    ]);
  }

    header("Location: mypage.php");
}
$sql7 = "SELECT * FROM  tag";
$statement = $pdo->prepare($sql7);
$statement->execute();
$tags =$statement->fetchAll();

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
        <h2>新規作成</h2>
        　<form action="" method="post">
          <p>タイトル:<input type="text" name="title" size="50" maxlength="50" value=""></p>
          <p>コンテンツ：<textarea name="body" rows="5" cols="40"></textarea></p>
           <h2 id="m1headline">タグ</h2>
           <p id="m1content">
           <?php
           foreach($tags as $tag){
           ?>
             <input type="checkbox"name="tags[]"value="<?php echo $tag["id"];?>">
             <?php echo $tag["tag"];
           }?></p>
           <input type="submit" value="募集" class="btn signup">
        </form>
    </div>
    <footer>
      <div class="container">
        <p>BLANCIEL Knowledge</p>
      </div>
    </footer>
  </body>
</html>
