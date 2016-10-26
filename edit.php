<?php
//DB接続
  $dsn = 'mysql:dbname=myfriends;host=localhost';   //同じサーバに入っていたらlocalhost
  $user = 'root';   //xampで決まってる　userという変数を作成してrootっていう文字を入れてます。
  $password='';     //xampで決まってる
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');    //これがないと文字化けしちゃうよ！


// //UPDATE処理?
//   if(!empty($_GET['action']) && ($_GET['action'] == 'update')){

//   $friend_name = $_POST['friend_name'];
//   $area_id = $_POST['area_id'];
//   $gender = $_POST['gender'];
//   $age = $_POST['age'];

//   $sql = "UPDATE `friends` SET `friend_name`='".$friend_name."', `area_id`='".$area_id."', `gender`='".$gender."', `age`='".$age."' WHERE `friend_id`=".$_GET['friend_id'];

//   $stmt = $dbh->prepare($sql);
//   $stmt->execute();

//   //二重に実行されないように、最初のURLへリダイレクト
//   header('Location:index.php');
//   exit;
// }

//編集対象となる友達データ一覧を取得
  $friend_id = $_GET['friend_id'];
  $sql = 'SELECT * FROM `friends` WHERE `friend_id`=' . $friend_id;

  $stmt = $dbh->prepare($sql); 
  $stmt->execute();

 //フォームの値(value)に取得したデータを表示
  $friends = $stmt->fetch(PDO::FETCH_ASSOC);

   echo '<br>';
   echo '<br>';
   echo '<pre>';
   var_dump($friends);
   echo '</pre>';    
   echo $friends["friend_name"];



//area_nameをselectedで表示　areasから全件出力
  $sql = 'SELECT * FROM `areas` WHERE 1';

  $stmt = $dbh->prepare($sql); 
  $stmt->execute();

//配列を作成
  $areas = array();

//While
  while(1){
  //fetch
      $record = $stmt->fetch(PDO::FETCH_ASSOC);
  //if break      
      if ($record == false) {
          break;
      }
  //配列にデータを格納
  $areas[] = $record;
}


 
//UPDATE処理 

if(!empty($_POST)){
  //update文を作成して実行(friend_idが3の時に)
$sql = 'UPDATE `friends` SET `friend_name`=?, `area_id`=?, `gender`=?, `age`=? WHERE `friend_id`=?';

$edit_data[] = $_POST['name'];
$edit_data[] = $_POST['area_id'];
$edit_data[] = $_POST['gender'];
$edit_data[] = $_POST['age'];
$edit_data[] = $friend_id;//$_GETfriend_idから持ってきたデータを入れる？

$stmt = $dbh->prepare($sql);
$stmt->execute($edit_data);

  //二重に実行されないように、最初のURLへリダイレクト
  header('Location:index.php');
  exit();

}
 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>友達の編集</legend>


        <form method="post" action="edit.php?friend_id=<?php echo $friend_id; ?>" class="form-horizontal" role="form">
            <!-- 名前 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="山田　太郎" value="<?php echo $friends['friend_name']; ?>"><!--全体の""がある場合は中身は''にしないと表示されない
            -->
              </div>
            </div>
            <!-- 出身 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">
                <select class="form-control" name="area_id">
                  <option value="0">出身地を選択</option>
                  <!--
                  1.new.phpを参考に都道府県データを繰り返し表示
                  2.$friendsのarea_idと、繰り返し生成される$area_idが一致したらselectedをoptionタグにつける
                  -->
                  <!--option value="1" selected></option-->
                  <?php foreach ($areas as $area) : ?>
                    <?php if($friends['area_id'] == $area['area_id']): ?>
                      <option value="<?php echo $area['area_id']; ?>" selected><?php echo $area['area_name']; ?></option>
                    <?php else: ?>
                      <option value="<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>     
                </select>
              </div>
            </div>
             
            <!-- 性別 -->
      
            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">
                  <option value="0">性別を選択</option>

                <!--
                  if文を使って、
                  もしDBから取得した友達データのgenderの値が0だった場合は、男性にselectedを、
                  1だった場合は女性にselectedをつける
                -->

                <?php if($friends['gender'] == 0): ?>
                  <option value="0" selected>男性</option>
                  <option value="1">女性</option>
                <?php else: ?>
                  <option value="0">男性</option>
                  <option value="1" selected>女性</option>
                <?php endif; ?>
                </select>
              </div>
            </div>
            <!-- 年齢 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="age" class="form-control" placeholder="例：27" value="<?php echo $friends['age']; ?>">
              </div>
            </div>

          <input type="submit" class="btn btn-default" value="更新">
        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
