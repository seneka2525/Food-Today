<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「マイページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
// require('auth.php');
?>
<!-- ヘッド -->
<?php
$siteTitle = 'HOME';
require('head.php');
?>

<body>
  <!-- ヘッダー -->
  <?php
  require('header.php');
  ?>
  <!-- jsの変更完了メッセージ -->
  <p id="js-show-msg" style="display:none" class="msg-slide">
    <?php echo getSessionFlash('msg_success'); ?>
  </p>

  <!-- マイページ -->
  <div class="site-width">
    <main class="ly-main">
      <div class="page-title-wrap">
        <h1 class="page-title title">MyPage</h1>
      </div>
      <div class="mypage__wrap main__wrap">


        <!-- 投稿一覧 -->
        <section class="mypage-wrap">
          <h2 class="mypage-wrap__sub-title sub-title">投稿料理一覧</h2>
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
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
          </div>
        </section>

        <!-- お気に入り -->
        <section class="like-wrap">
          <h2 class="like-wrap__sub-title sub-title">お気に入り一覧</h2>
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
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
            <a href="productDetail.html" class="panel-list__img">
              <div class="panel-list__panel-head">
                <img src="images/price1.jpg" alt="食べ物タイトル">
              </div>
              <div class="panel-list__panel-body">
                <p class="panel-list__panel-title">唐揚げ <span class="price">¥750</span></p>
              </div>
            </a>
          </div>
        </section>
      </div>

      <!-- サイドバー -->
      <aside class="content__2column mypage">
        <section class="side-bar">
          <ul class="side-bar__list">
            <li class="side-bar__item"><a href="registProduct.php">料理を投稿する</a></li>
            <li class="side-bar__item"><a href="profEdit.php">プロフィール編集</a></li>
            <li class="side-bar__item"><a href="profEdit.html"></a></li>
            <li class="side-bar__item"><a href="passEdit.php">パスワード変更</a></li>
            <li class="side-bar__item"><a href="withdraw.php">退会</a></li>
          </ul>
        </section>
      </aside>
    </main>
  </div>

  <!-- footer -->
  <?php
  require('footer.php');
  ?>
</body>