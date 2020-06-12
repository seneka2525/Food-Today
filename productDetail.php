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
      <span class="badge">中華</span>
      唐揚げ
    </div>
    <div class="product-img-container">
      <div class="img-main">
        <img src="images/price2.jpg" alt="">
      </div>
      <div class="img-sub">
        <img src="images/price1.jpg" alt="">
        <img src="images/price2.jpg" alt="">
        <img src="images/price3.jpg" alt="">
      </div>
    </div>
    <div class="product-detail-left">
      <p class="product-detail-left__recipe">
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
        サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
      </p>
    </div>
    <div class="product-detail-right">
      <p class="product-detail-right__comment">
          サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
      </p>
    </div>
    <div class="product-item">
      <div class="product-item__left">
          <a href="index.php">&lt; 料理一覧に戻る</a>
      </div>
      <div class="product-item__right">
        <p class="product-item__price">¥750-</p>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php
  require('footer.php');
  ?>
</body>