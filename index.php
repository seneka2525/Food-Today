<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「トップページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// カレントページのGETパラメータを取得
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1; //デフォルトは１ページ目
// パラメータに不正な値が入っているかチェック
if(!is_int((int)$currentPageNum)){
  error_log('エラー発生：指定ページに不正な値が入りました');
  header("Location:index.php"); // トップページへ
}
// 表示件数
$listSpan = 8;
// 現在の表示レコード先頭を算出
$currentMinNum = (($currentPageNum-1)*$listSpan); // 1ページ目なら(1-1)*20 = 0 、  ２ページ目なら(2-1)*20 = 20
// DBから食べ物データを取得
$dbProductData = getProductList($currentMinNum);
// DBからカテゴリデータを取得
$dbCategoryData = getCategory();
debug('現在のページ：'.$currentPageNum);
// debug('フォーム用DBデータ：'.print_r($dbFormData,true));
debug('カテゴリデータ：'.print_r($dbCategoryData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = 'HOME';
require('head.php');
?>
<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>HOME | 今日、何食べる？</title>
</head> -->

<body>
  <!-- ヘッダー -->
  <!-- <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="mypage.php">マイページ</a></li>
        <li class="header__link"><a href="logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header> -->
  <?php
  require('header.php');
  ?>

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
          <span class="total-num"><?php echo sanitize($dbProductData['total']); ?></span>件の食べ物が見つかりました
        </div>
        <div class="search-right">
          <span class="num"><?php echo $currentMinNum+1; ?></span> - <span class="num"><?php echo $currentMinNum+$listSpan; ?></span>件 / <span class="num"><?php echo sanitize($dbProductData['total']); ?></span>件中
        </div>
      </div>
      <!-- パネル表示 -->
      <div class="panel-list">
        <?php
          foreach($dbProductData['data'] as $key => $val):
        ?>
        <a href="productDetail.php?p_id=<?php echo $val['id']; ?>" class="panel-list__img">
          <div class="panel-list__panel-head">
            <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
          </div>
          <div class="panel-list__panel-body">
            <p class="panel-list__panel-title"><?php echo sanitize($val['name']); ?> <span class="price">¥<?php echo sanitize(number_format($val['price'])); ?></span></p>
          </div>
        </a>
        <?php
          endforeach;
        ?>

      </div>

      <!-- ページネーション -->
      <div class="pagination">
        <ul class="pagination__list">
          <?php
          $pageColNum = 5;
          $totalPageNum = $dbProductData['total_page'];
          // 現在のページが、総ページ数と同じかつ総ページ数が表示項目以上なら、左にリンクを４個出す
          if( $currentPageNum == $totalPageNum && $totalPageNum >= $pageColNum){
            $minPageNum = $currentPageNum - 4;
            $maxPageNum = $currentPageNum;
          // 現在のページが、総ページ数の１ページ前なら、左にリンクを３個、右に１個出す
          }elseif( $currentPageNum == ($totalPageNum-1) && $totalPageNum >= $pageColNum){
            $minPageNum = $currentPageNum - 3;
            $maxPageNum = $currentPageNum + 1;
          // 現ページが２の場合は左にリンク１個、右に３個出す
          }elseif( $currentPageNum == 2 && $totalPageNum >= $pageColNum){
            $minPageNum = $currentPageNum - 1;
            $maxPageNum = $currentPageNum + 3;
          // 現ページが１の場合が左に何も出さない。右に５個出す。
          }elseif( $currentPageNum == 1 && $totalPageNum >= $pageColNum){
            $minPageNum = $currentPageNum;
            $maxPageNum = 5;
          // 総ページ数が表示項目数より少ない場合は、総ページ数をループのMax、ループのMinを１に設定
          }elseif( $totalPageNum < $pageColNum){
            $minPageNum = 1;
            $maxPageNum = $totalPageNum;
          // それ以外は左に２個出す。
          }else{
            $minPageNum = $currentPageNum - 2;
            $maxPageNum = $currentPageNum + 2;
          }
          ?>
          <?php if($currentPageNum != 1): ?>
            <li class="list-item"><a href="?p=1">&lt;</a></li>
           <?php endif; ?>
           <?php
            for($i = $minPageNum; $i <= $maxPageNum; $i++):
           ?>
            <li class="list-item <?php if($currentPageNum == $i ) echo 'active'; ?>"><a href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php
            endfor;
          ?>
          <?php if($currentPageNum != $maxPageNum): ?>
            <li class="list-item"><a href="?p=<?php echo $maxPageNum; ?>">&gt;</a></li>
          <?php endif; ?>
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