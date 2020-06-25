<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「マイページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
// ログイン認証
require('auth.php');

// 画面表示用データ取得
//================================
$u_id = $_SESSION['user_id'];
// DBから食べ物データを取得
$productData = getMyProducts($u_id);
// DBからお気に入りデータを取得
$likeData = getMyLike($u_id);

// DBからデータがすべて取れているかのチェックは行わず、取れなければ何も表示しないこととする

debug('取得した食べ物データ：'.print_r($productData,true));
debug('取得したお気に入りデータ：'.print_r($likeData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<!-- ヘッド -->
<?php
$siteTitle = 'マイページ';
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
            <?php
              if(!empty($productData)):
                foreach($productData as $key => $val):
            ?>
              <a href="registProduct.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
                <div class="panel-head">
                  <img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['name']); ?>">
                </div>
                <div class="panel-body">
                  <p class="panel-title"><?php echo sanitize($val['name']); ?> <span class="price">¥<?php echo sanitize(number_format($val['price'])); ?></span></p>
                </div>
              </a>
              <?php
                endforeach;
              endif;
              ?>
          </div>
        </section>

        <!-- お気に入り -->
        <section class="like-wrap">
          <h2 class="like-wrap__sub-title sub-title">お気に入り一覧</h2>
          <!-- パネル表示 -->
          <div class="panel-list">
            <?php
              if(!empty($likeData)):
                foreach($likeData as $key => $val):
            ?>
              <a href="productDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
                <div class="panel-head">
                  <img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['name']); ?>">
                </div>
                <div class="panel-body">
                  <p class="panel-title"><?php echo sanitize($val['name']); ?> <span class="price">¥<?php echo sanitize(number_format($val['price'])); ?></span></p>
                </div>
              </a>
              <?php
                endforeach;
              endif;
              ?>
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