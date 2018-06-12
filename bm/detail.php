<?php


$id = $_GET["id"];


//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('dbError:'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id ");
$stmt->bindValue(":id",$id);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  $rs = $stmt->fetch();
}
?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>本の登録</legend>
     <label>名前：<input type="text" name="name" value="<?=$rs["name"]?>"></label><br>
     <label>URL：<input type="text" name="url" value="<?=$rs["url"]?>"></label><br>
     <!-- <label>ファイル：<input type="file" name="up_file"></label><br> -->
     <label>感想：<textArea name="comment" rows="4" cols="40"><?=$rs["comment"]?></textArea></label><br>
     <input type="submit" value="送信">
     <input type="hidden" name='id' value="<?=$rs["id"]?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
