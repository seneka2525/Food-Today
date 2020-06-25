<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「パスワード変更ページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================
// DBからユーザー情報を取得
$userData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報：' . print_r($userData, true));

// post送信されていた場合
if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POST情報：' . print_r($_POST, true));

  // 変数にユーザー情報を代入
  $pass_old = $_POST['pass_old'];
  $pass_new = $_POST['pass_new'];
  $pass_new_re = $_POST['pass_new_re'];

  // 未入力チェック
  validRequired($pass_old, 'pass_old');
  validRequired($pass_new, 'pass_new');
  validRequired($pass_new_re, 'pass_new_re');

  if (empty($err_msg)) {
    debug('未入力チェックOK!!');

    // 古いパスワードのチェック
    validPass($pass_old, 'pass_old');
    // 新しいパスワードのチェック
    validPass($pass_new, 'pass_new');

    // 古いパスワードとDBパスワードを照合（DBに入っているデータと同じであれば、
    // 半角英数字チェックや最大文字数チェックはおこなわなくても問題ない）
    if (!password_verify($pass_old, $userData['password'])) {
      $err_msg['pass_old'] = MSG10; // 古いパスワードと違います
    }

    // 新しいパスワードと古いパスワードが同じかチェック
    if ($pass_old === $pass_new) {
      $err_msg['pass_new'] = MSG11; // 古いパスワードと同じです
    }
    // パスワードとパスワード再入力が合っているかチェック（ログイン画面では最大、最小文字数チェック
    // もしていたがパスワードの方でチェックしていすので実は必要ない）
    validMatch($pass_new, $pass_new_re, 'pass_new_re');

    if (empty($err_msg)) {
      debug('バリデーションOKです！！');

      // 例外処理
      try {
        // DBへ接続
        $dbh = dbConnect();
        // SQL文作成
        $sql = 'UPDATE users SET password = :pass WHERE id = :id';
        $data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pass_new, PASSWORD_DEFAULT));
        // クエリ実行
        $stmt = queryPost($dbh, $sql, $data);

        // クエリ成功の場合
        if ($stmt) {
          $_SESSION['msg_success'] = SUC01;

          // メールを送信
          $username = ($userData['username']) ? $userData['username'] : '名無し';
          $from = 'stillaki2@gmail.com';
          $to = $userData['email'];
          $subject = 'パスワード変更通知 | eattoday';
          // EOTはendoftextの略。ABCでもなんでもいい。先頭の<<<の後の文字列と合わせること。
          // 最後のEOTの前後に空白など何も入れてはいけない。
          // EOT内の半角空白も全てそのまま半角空白として扱われるのでインデントはしないこと
          $comment = <<<EOT
{$username}　さん
パスワードが変更されました。

///////////////////////////////////////
eattoday yuji
URL  http://eattoday.com/
E-mail stillaki2@gmail.com
///////////////////////////////////////
EOT;
          sendMail($from, $to, $subject, $comment);

          header("Location:mypage.php"); // マイページへ
        }
      } catch (Exception $e) {
        error_log('エラー発生：' . $e->getMessage());
        $err_msg['common'] = MSG07; // エラーが発生しました。しばらく経ってからやり直してください。
      }
    }
  }
}
?>
<!-- ヘッド -->
<?php
$siteTitle = 'パスワード変更';
require('head.php');
?>

<body>
  <!-- ヘッダー -->
  <?php
  require('header.php');
  ?>

  <!-- パスワード変更フォーム -->
  <div class="site-width">
    <div class="page-title-wrap">
      <h1 class="page-title title">パスワード変更</h1>
    </div>
    <div class="form-wrap">
      <section class="pass-edit form-container">
        <form action="" method="post" class="pass-edit__form">
          <div class="area-msg">
            <?php
            echo getErrMsg('common');
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['pass_old'])) echo 'err'; ?>">
            古いパスワード
            <input type="password" name="pass_old" value="<?php echo getFormData('pass_old'); ?>">
          </label>
          <div class="area-msg">
            <?php
            echo getErrMsg('pass_old');
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['pass_new'])) echo 'err'; ?>">
            新しいパスワード
            <input type="text" name="pass_new" value="<?php echo getFormData('pass_new'); ?>">
          </label>
          <div class="area-msg">
            <?php
            echo getErrMsg('pass_new');
            ?>
          </div>
          <label class="<?php if (!empty($err_msg['pass_new_re'])) echo 'err'; ?>">
            新しいパスワード（再入力）
            <input type="text" name="pass_new_re" value="<?php echo getFormData('pass_new_re'); ?>">
          </label>
          <div class="area-msg">
            <?php
            echo getErrMsg('pass_new_re');
            ?>
          </div>
          <div class="pass-edit__btn-wrap btn-container">
            <input type="submit" class="pass-edit__btn btn" value="変更する">
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

</html>