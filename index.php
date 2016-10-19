

<?php
//1.データベースに接続する

//3.取得したareasテーブルの情報を表示

  $dsn = 'mysql:dbname=myfriends;host=localhost';   //同じサーバに入っていたらlocalhost
  $user = 'root';   //xampで決まってる　userという変数を作成してrootっていう文字を入れてます。
  $password='';     //xampで決まってる
  // $dsn = 'mysql:dbname=LAA0792978-onelinebbs;host=mysql102.phy.lolipop.lan';   //同じサーバに入っていたらlocalhost
  // $user = 'LAA0792978';
  // $password='urepamin1012';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');    //これがないと文字化けしちゃうよ！

  //2.DBからareasテーブルの情報を取得
    $sql = 'SELECT * FROM `areas` order by area_id ASC';
  //DB名、テーブル名、カラム名はアクサングラーブで囲う　shift+@で表示できる。
  //SQL文の中では省略可

    var_dump($sql);

  // SQLを実行 実行するにはこの２行が必要
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    //$recordデータ格納用の配列（変数名はなんでもいい）
    //空のタンスを作る

    $hogehoge = array();

    // 取得したareasテーブルの情報を表示
    while (1) {
      //カッコの中がtrueの限りずっと処理を続ける。1はtrue
      //$recordはareasテーブルのレコード1件を格納した連想配列
      //$record = array('area_id' => 2, 'area_name' => '青森県');
      //別の配列データにそれぞれを格納してあげる。
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
          break;
        }
    

      //取得したデータを配列に格納しておく
      $hogehoge[] = $record;

      //var_dump($hogehoge);
    }

    // echo '<br>';
    // echo '<br>';
    // echo '<br>';
    // echo count($hogehoge); //hogehoegの中にどれだけデータが入っていたか
  
 // ３．データベースを切断する
  $dbh = null;
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
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
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
      <legend>都道府県一覧</legend>
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">ID</div></th>
              <th><div class="text-center">県名</div></th>
              <th><div class="text-center">人数</div></th>
            </tr>
          </thead>
          <tbody>
                <!-- id, 県名を表示 -->
        <!--カッコを使う書き方-->
        <?php   {   ?>
        <?php } ?>

        <!---カッコを使わない書き方-->
        <?php foreach ($hogehoge as $area_each) : ?>  
        <!-- $ area = arry('area_id'=>1, 'area_name'=>'北海道');--> 
                <tr>
                  <td><div class="text-center"><?php echo ($area_each['area_id']); ?></div></td>
                  <td>
                    <div class="text-center">
                      <a href="show.php">
                        <?php echo ($area_each['area_name']); ?>
                      </a>
                    </div>
                  </td>
                  <td><div class="text-center">3</div></td>
                </tr>

          <?php endforeach; ?>



          </tbody>
        </table>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
