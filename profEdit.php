<?php

// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「プロフィール変更ページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================
// DBからユーザー情報を取得
$dbFormData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報：' . print_r($dbFormData, true));

// post送信されていた場合
if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POST情報：' . print_r($_POST, true));

  // 変数にユーザー情報を代入
  $username = $_POST['username'];
  $email = $_POST['email'];
  $food = $_POST['food'];

  // DBの情報と入力情報が異なる場合にバリデーションを行う
  if ($dbFormData['username'] !== $username) {
    // 名前の最大文字数チェック
    validMaxLen($username, 'username');
  }
  if ($dbFormData['email'] !== $email) {
    // emailの最大文字数チェック
    validMaxLen($email, 'email');
    if (empty($err_msg['email'])) {
      // emailの重複チェック
      validEmailDup($email);
    }
    // email形式チェック
    validEmail($email, 'email');
    // emailの未入力チェック
    validRequired($email, 'email');
  }
  if ($dbFormData['food'] !== $food) {
    validMaxLen($food, 'food');
  }

  // エラーメッセージがない場合
  if (empty($err_msg)) {
    debug('バリデーションOKです!!');

    // 例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'UPDATE users SET username = :u_name, email = :email, food = :food WHERE id = :u_id';
      $data = array(':u_name' => $username, ':email' => $email, ':food' => $food, ':u_id' => $dbFormData['id']);
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);

      // クエリ成功の場合
      if ($stmt) {
        $_SESSION['msg_success'] = SUC02;
        debug('マイページへ遷移します。');
        header("Location:mypage.php"); // マイページへ
      }
    } catch (Exception $e) {
      error_log('エラー発生：' . $e->getMessage());
      $err_msg['common'] = MSG07; // エラーが発生しました。しばらく経ってからやり直してください。
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
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

  <!-- プロフィール編集フォーム -->
  <div class="site-width">
    <div class="page-title-wrap">
      <h1 class="page-title title">プロフィール編集</h1>
    </div>
    <div class="form-wrap">
      <section class="edit-form prof-edit form-container">
        <form action="" class="prof-edit__form" method="post">
          <div class="area-msg">
            <?php
            if (!empty($err_msg['common'])) echo $err_msg['common'];
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['username'])) echo 'err'; ?>">
            名前
            <input type="text" name="username" value="<?php echo getFormData('username'); ?>">
          </label>
          <div class="area-msg">
            <?php
            if (!empty($err_msg['username'])) echo $err_msg['username'];
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['email'])) echo 'err'; ?>">
            Email
            <input type="text" name="email" value="<?php echo getFormData('email'); ?>">
          </label>
          <div class="area_msg">
            <?php
            if ((!empty($err_msg['email']))) echo $err_msg['email'];
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['food'])) echo 'err'; ?>">
            好きな食べ物
            <input type="text" name="food" value="<?php echo getFormData('food'); ?>">
          </label>
          <div class="area-msg">
            <?php
            if (!empty($err_msg['food'])) echo $err_msg['food'];
            ?>
          </div>

          <div class="prof-edit__btn-wrap btn-container">
            <input type="submit" class="signup__btn btn" value="変更する">
          </div>
        </form>
      </section>
    </div>

    <!-- サイドバー -->
    <aside class="content__2column pass-edit">
      <section class="side-bar">
        <ul class="side-bar__list">
          <li class="side-bar__item"><a href="registProduct.php">料理を投稿する</a></li>
          <li class="side-bar__item"><a href="profEdit.php">プロフィール編集</a></li>
          <li class="side-bar__item"><a href="profEdit.php"></a></li>
          <li class="side-bar__item"><a href="passEdit.php">パスワード変更</a></li>
          <li class="side-bar__item"><a href="withdraw.php">退会</a></li>
        </ul>
      </section>
    </aside>
  </div>

  <!-- footer -->
  <?php
  require('footer.php');
  ?>
</body>