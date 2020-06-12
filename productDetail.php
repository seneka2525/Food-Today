<?php
// 共通変数・関数読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「食べ物詳細ページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// 食べ物IDのGETパラメータを取得
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
// DBから食べ物データを取得
$viewData = getproductOne($p_id);
// パラメータに不正な値が入っているかチェック
if(empty($viewData)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php"); // トップページへ
}
debug('取得したDBデータ：'.print_r($viewData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>料理詳細 | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="login.php">ログイン</a></li>
        <li class="header__link"><a href="signup.php">ユーザー登録</a></li>
      </ul>
    </div>
  </header>

  <!-- 詳細表示 -->
  <div class="site-width">
    <div class="food-title">
      <span class="badge"><?php echo sanitize($viewData['category']); ?></span>
      <?php echo sanitize($viewData['name']); ?>
    </div>
    <div class="product-img-container">
      <div class="img-main">
        <img src="<?php echo showImg(sanitize($viewData['pic1'])); ?>" alt="メイン画像：<?php echo sanitize($viewData['name']); ?>" id="js-switch-img-main">
      </div>
      <div class="img-sub">
        <img src="<?php echo showImg(sanitize($viewData['pic1'])); ?>" alt="画像１：<?php echo sanitize($viewData['name']); ?>" class="js-switch-img-sub">
        <img src="<?php echo showImg(sanitize($viewData['pic2'])); ?>" alt="画像２：<?php echo sanitize($viewData['name']); ?>" class="js-switch-img-sub">
        <img src="<?php echo showImg(sanitize($viewData['pic3'])); ?>" alt="画像３：<?php echo sanitize($viewData['name']); ?>" class="js-switch-img-sub">
      </div>
    </div>
    <div class="product-detail-left">
      <p class="product-detail-left__recipe"><?php echo sanitize($viewData['recipe']); ?></p>
    </div>
    <div class="product-detail-right">
      <p class="product-detail-right__comment"><?php echo sanitize($viewData['comment']); ?></p>
    </div>
    <div class="product-item">
      <div class="product-item__left">
          <a href="index.php<?php appendGetParam(array('p_id')); ?>">&lt; 料理一覧に戻る</a>
      </div>
      <div class="product-item__right">
        <p class="product-item__price">¥<?php echo sanitize(number_format($viewData['price'])); ?></p>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php
  require('footer.php');
  ?>
</body>