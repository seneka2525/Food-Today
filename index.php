<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>HOME | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="mypage.php">マイページ</a></li>
        <li class="header__link"><a href="logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <!-- メインコンテンツ -->
  <div class="content content-width">

    <!-- サイドバー (検索フォーム) -->
    <aside class="content__2column">
      <section class="search-form">
        <form action="" method="POST">
          <h1 class="search-form__title">カテゴリー</h1>
          <div class="search-form__selectbox">
            <select name="category">
              <option value="1">和食</option>
              <option value="2">中華</option>
            </select>
          </div>
          <h1 class="search-form__title">表示順</h1>
          <div class="search-form__selectbox">
            <select name="sort">
              <option value="1">金額が安い順</option>
              <option value="2">金額が高い順</option>
            </select>
          </div>
          <input type="submit" value="検索">
        </form>
      </section>
    </aside>

    <!-- コンテンツ表示エリア -->
    <!-- 検索数カウント -->
    <section class="main">
      <div class="search-title">
        <div class="search-left">
          <span class="total-num">124</span>件の食べ物が見つかりました
        </div>
        <div class="search-right">
          <span class="num">1</span> - <span class="num">10</span>件 / <span class="num">124</span>件中
        </div>
      </div>
      <!-- パネル表示 -->
      <div class="panel-list">
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
        <a href="productDetail.php" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="images/price1.jpg" alt="食べ物タイトル">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
          </div>
        </a>
      </div>

      <!-- ページネーション -->
      <div class="pagination">
        <ul class="pagination__list">
          <li class="pagination__list-item"><a href="">&lt;</a></li>
          <li class="pagination__list-item"><a href="">1</a></li>
          <li class="pagination__list-item"><a href="">2</a></li>
          <li class="pagination__list-item active"><a href="">3</a></li>
          <li class="pagination__list-item"><a href="">4</a></li>
          <li class="pagination__list-item"><a href="">5</a></li>
          <li class="pagination__list-item"><a href="">&gt;</a></li>
        </ul>
      </div>
    </section>
  </div>

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.php">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>
</body>