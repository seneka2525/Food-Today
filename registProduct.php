<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「食べ物登録ページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// GETデータを格納
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
// DBから商品データを取得
$dbformData = (!empty($p_id)) ? getProduct($_SESSION['user_id'], $p_id) : '';
// 新規登録画面か編集画面か判定用フラグ
$edit_flg = (empty($dbFormdata)) ? false : true;
// DBからカテゴリデータを取得
$dbCategoryData = getCategory();
debug('商品ID：' . $p_id);
debug('フォーム用DBデータ：' . print_r($dbformData, true));
debug('カテゴリデータ：' . print_r($dbCategoryData, true));

// パラメータ改ざんチェック
//================================
// GETパラメータはあるが、改ざんされている（URLをいじった）
// 場合、正しい食べ物データが取れないのでマイページへ遷移させる
if (!empty($p_id) && empty($dbFormData)) {
  debug('GETパラメータの商品IDが違います。マイページへ遷移します。');
  header("Location:mypage.php"); // マイページへ
}

// POST送信時処理
//================================
if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POST情報：' . print_r($_POST, true));
  debug('FILE情報：' . print_r($_FILES, true));

  // 変数にユーザー情報を代入
  $name = $_POST['name'];
  $category = $_POST['category_id'];
  $recipe = $_POST['recipe'];
  // ０や空文字の場合は０を入れる。デフォルトのフォームには０が入っている
  $price = (!empty($_POST['price'])) ? $_POST['price'] : 0;
  $comment = $_POST['comment'];
  // 画像をアップロードし、パスを格納
  $pic1 = (!empty($_FILES['pic1']['name'])) ? uploadImg($_FILES['pic1'], 'pic1') : ''; // 新規登録用
  // 画像をPOSTしていない（登録していない）が既にDBに登録されている場合、DBのパスを入れる（POSTには反映されないので）
  $pic1 = (empty($pic1) && !empty($dbFormData['pic1'])) ? $dbFormData['pic1'] : $pic1; // 編集画面用
  $pic2 = (!empty($_FILES['pic2']['name'])) ? uploadImg($_FILES['pic2'], 'pic2') : ''; // 新規登録用
  $pic2 = (empty($pic2) && !empty($dbFormData['pic2'])) ? $dbFormData['pic2'] : $pic2; // 編集画面用
  $pic3 = (!empty($_FILES['pic3']['name'])) ? uploadImg($_FILES['pic3'], 'pic3') : ''; // 新規登録用
  $pic3 = (empty($pic3) && !empty($dbFormData['pic3'])) ? $dbFormData['pic3'] : $pic3; // 編集画面用

  // 更新の場合はDBの情報と入力情報が異なる場合にバリデーションを行う
  if (empty($dbFormData)) {
    // 未入力チェック
    validRequired($name, 'name');
    // 最大文字数チェック
    validMaxLen($name, 'name');
    // セレクトボックスチェック
    validSelect($category, 'category_id');
    // 最大文字数チェック
    validMaxLen($recipe, 'recipe', 500);
    // 最大文字数チェック
    validMaxLen($comment, 'comment', 500);
    // 未入力チェック
    validRequired($price, 'price');
    // 半角数字チェック
    validNumber($price, 'price');
  } else {
    if ($dbFormData['name'] !== $name) {
      // 未入力チェック
      validRequired($name, 'name');
      // 最大文字数チェック
      validMaxLen($name, 'name');
    }
    if ($dbFormData['recipe'] !== $recipe) {
      // 最大文字数チェック
      validMaxLen($recipe, 'recipe');
    }
    if ($dbFormData['category_id'] !== $category) {
      // セレクトボックスチェック
      validSelect($category, 'category_id');
    }
    if ($dbFormData['comment'] !== $comment) {
      // 最大文字数チェック
      validMaxLen($comment, 'comment', 500);
    }
    if ($dbFormData['price'] != $price) { // 前回ではキャストしていたが、ゆるい判定でもいい
      // 未入力チェック
      validRequired($price, 'price');
      // 半角数字チェック
      validNumber($price, 'price');
    }
  }

  if (empty($err_msg)) {
    debug('バリデーションOKです！！');

    // 例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      // 編集画面の場合はUPDATE文、新規登録画面の場合はINSERT文を生成
      if ($edit_flg) {
        debug('DB更新です。');
        $sql = 'UPDATE product SET name = :name, category_id = :category, recipe = :recipe, price = :price,
        comment = :comment, pic1 = :pic1, pic2 = :pic2, pic3 = :pic3 WHERE user_id = :u_id AND id = :p_id';
        $data = array(
          ':name' => $name, ':category' => $category, ':recipe' => $recipe, ':price' => $price, ':comment' => $comment,
          ':pic1' => $pic1, ':pic2' => $pic2, ':pic3' => $pic3, ':u_id' => $_SESSION['user_id'], ':p_id' => $p_id
        );
      } else {
        debug('DB新規登録です。');
        $sql = 'INSERT INTO product (name, category_id, recipe, price, comment, pic1, pic2, pic3, user_id, create_date )
                values (:name, :category, :recipe, :price, :comment, :pic1, :pic2, :pic3, :u_id, :date)';
        $data = array(
          ':name' => $name, ':category' => $category, ':recipe' => $recipe, ':price' => $price, ':comment' => $comment,
          ':pic1' => $pic1, ':pic2' => $pic2, ':pic3' => $pic3, ':u_id' => $_SESSION['user_id'], ':date' => date('Y-m-d H:i:s')
        );
      }
      debug('SQL：' . $sql);
      debug('流し込みデータ：' . print_r($data, true));
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);

      // クエリ成功の場合
      if ($stmt) {
        $_SESSION['msg_success'] = SUC04;
        debug('マイページへ遷移します。');
        header("Location:mypage.php");
      }
    } catch (Exception $e) {
      error_log('エラー発生：' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = (!$edit_flg) ? '食べ物登録' : '食べ物編集';
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
  <title>料理登録 | 今日、何食べる？</title>
</head> -->

<body>
  <!-- メニュー -->
  <?php
  require('header.php');
  ?>
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

  <!-- 食べ物登録・編集フォーム -->
  <div class="site-width">
    <div class="page-title-wrap">
      <h1 class="page-title title"><?php echo (!$edit_flg) ? '食べ物を投稿する' : '食べ物を編集する'; ?></h1>
    </div>
    <section class="product-edit form-container">
      <form action="" method="post" class="product-edit__form" enctype="multipart/form-data">
        <div class="area-msg">
          <?php
          if (!empty($err_msg['common'])) echo $err_msg['common'];
          ?>
        </div>
        <label class="<?php if (!empty($err_msg['name'])) echo 'err'; ?>">
          料理名
          <input type="text" name="name" value="<?php echo getFormData('name'); ?>">
        </label>
        <div class="area-msg">
          <?php
          if (!empty($err_msg['name'])) echo $err_msg['name'];
          ?>
        </div>
        <label class="<?php if (!empty($err_msg['category_id'])) echo 'err'; ?>">
          カテゴリ<span class="label-require">必須</span>
          <select name="category_id" id="">
            <option value="0" <?php if (getformData('category_id') == 0) {
                                echo 'selected';
                              } ?>>選択してください</option>
            <?php
            foreach ($dbCategoryData as $key => $val) {
            ?>
              <option value="<?php echo $val['id'] ?>" <?php if (getFormData('category_id') == $val['id']) {
                                                          echo 'selected';
                                                        } ?>>
                <?php echo $val['name']; ?>
              </option>
            <?php
            }
            ?>
          </select>
        </label>
        <div class="area-msg">
          <?php
          if (!empty($err_msg['category_id'])) echo $err_msg['category_id'];
          ?>
        </div>
        <label class="<?php if (!empty($err_msg['recipe'])) echo 'err'; ?>">
          レシピ
          <textarea name="recipe" id="comment1" cols="30" rows="10"><?php echo getFormData('recipe'); ?></textarea>
        </label>
        <p class="counter-text"><span id="count1">0</span>/500文字</p>
        <div class="area-msg">
          <?php
          if (!empty($err_msg['recipe'])) echo $err_msg['recipe'];
          ?>
        </div>
        <label class="<?php if (!empty($err_msg['comment'])) echo 'err'; ?>">
          詳細
          <textarea name="comment" id="comment2" cols="30" rows="10"><?php echo getFormData('comment'); ?></textarea>
        </label>
        <p class="counter-text"><span id="count2">0</span>/500文字</p>
        <div class="area-msg">
          <?php
          if (!empty($err_msg['comment'])) echo $err_msg['comment'];
          ?>
        </div>
        <label class="<?php if (!empty($err_msg['price'])) echo 'err'; ?>">
          金額<span class="label-require">必須</span>
          <div class="product-edit__price">
            <input type="text" name="price" value="<?php echo (!empty(getformData('price'))) ? getFormData('price') : 0; ?>"><span class="option">円</span>
          </div>
        </label>
        <div class="area-msg">
          <?php
          if (!empty($err_msg['price'])) echo $err_msg['price'];
          ?>
        </div>
        <div style="overflow:hidden">
          <div class="imgDrop-container">
            画像１
            <label class="area-drop <?php if (!empty($err_msg['pic1'])) echo 'err'; ?>">
              <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
              <input type="file" name="pic1" class="input-file">
              <img src="<?php echo getFormData('pic1'); ?>" alt="" class="prev-img" style="<?php if (empty(getFormData('pic1'))) echo 'display:none;' ?>">
              ドラッグ＆ドロップ
            </label>
            <div class="area-msg">
              <?php
              if (!empty($err_msg['pic1'])) echo $err_msg['pic1'];
              ?>
            </div>
          </div>
          <div class="imgDrop-container">
            画像２
            <label class="area-drop <?php if (!empty($err_msg['pic2'])) echo 'err'; ?>">
              <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
              <input type="file" name="pic2" class="input-file">
              <img src="<?php echo getFormData('pic2'); ?>" alt="" class="prev-img" style="<?php if (empty(getFormData('pic2'))) echo 'display:none;' ?>">
              ドラッグ＆ドロップ
            </label>
            <div class="area-msg">
              <?php
              if (!empty($err_msg['pic2'])) echo $err_msg['pic2'];
              ?>
            </div>
          </div>
          <div class="imgDrop-container">
            画像３
            <label class="area-drop <?php if (!empty($err_msg['pic3'])) echo 'err'; ?>">
              <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
              <input type="file" name="pic3" class="input-file">
              <img src="<?php echo getFormData('pic3'); ?>" alt="" class="prev-img" style="<?php if (empty(getFormData('pic3'))) echo 'display:none;' ?>">
              ドラッグ＆ドロップ
            </label>
            <div class="area-msg">
              <?php
              if (!empty($err_msg['pic3'])) echo $err_msg['pic3'];
              ?>
            </div>
          </div>
        </div>

        <div class="product-edit__btn-wrap btn-container">
          <input type="submit" class="product-edit__btn btn" value="<?php echo (!$edit_flg) ? '登録する' : '更新する'; ?>">
        </div>
      </form>
    </section>

    <!-- サイドバー -->
    <aside class="content__2column">
      <section class="side-bar">
        <ul class="side-bar__list">
          <li class="side-bar__item"><a href="registProduct.php">料理を投稿する</a></li>
          <li class="side-bar__item"><a href="profEdit.php">プロフィール編集</a></li>
          <li class="side-bar__item"><a href="passEdit.php">パスワード変更</a></li>
          <li class="side-bar__item"><a href="withdraw.php">退会</a></li>
        </ul>
      </section>
    </aside>
  </div>

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.php">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="js/vendor/jquery-2.2.2.min.js"></script>
  <!-- メッセージを表示 -->
  <script>
    $(function() {
      var $jsShowMsg = $('#js-show-msg');
      var msg = $jsShowMsg.text();
      if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
        $jsShowMsg.slideToggle('show');
        setTimeout(function() {
          $jsShowMsg.slideToggle('show');
        }, 5000);
      }

      // 画像ライブプレビュー
      var $dropArea = $('.area-drop');
      var $fileInput = $('.input-file');
      $dropArea.on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '3px #ccc dashed');
      });
      $dropArea.on('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', 'none');
      });
      $fileInput.on('change', function(e) {
        $dropArea.css('border', 'none');
        var file = this.files[0],               // 2. files配列にファイルが入っています
          $img = $(this).siblings('.prev-img'), // 3. jQueryのsiblingsメソッドで兄弟のimgを取得
          fileReader = new FileReader();        // 4. ファイルを読み込むfileReaderオブジェクト

        // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
        fileReader.onload = function(event) {
          // 読み込んだデータをimgに設定
          $img.attr('src', event.target.result).show();
        };

        // 6. 画像読み込み
        fileReader.readAsDataURL(file);

      });

      // テキストエリアカウント
      $('#comment1,#comment2,#comment3').bind('keyup',function() {
        for ( num=1; num<=3; num++ ) {
            var thisValueLength = $('#comment' + num).val().replace(/\s+/g,'').length;
            $("#count" + num).html(thisValueLength);
        }
    });

    });
  </script>
</body>