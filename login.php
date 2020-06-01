<?php

// 共通変数・関数ファイル読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「ログインページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// ログイン画面処理
//================================
// post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります。');

  //  変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_save = (!empty($_POST['pass_save'])) ? true : false; //ショートハンド（略記法）

  // emailの形式チェック
  validEmail($email, 'email');
  // emailの最大文字数チェック
  validMaxLen($email, 'email');

  // パスワードの半角英数字チェック
  validHalf($pass, 'pass');
  // パスワードの最大文字数チェック
  validMaxLen($pass, 'pass');
  // パスワードの最小文字数チェック
  validMinLen($pass, 'pass');

  // 未入力チェック
  validRequired($email, 'email');
  validRequired($pass, 'pass');

  if(empty($err_msg)){
    debug('バリデーションOKです。');

    // 例外処理
    try {
      $dbh = dbconnect();
      // SQL文作成
      $sql = 'SELECT password,id FROM rsers WHERE email = :email';
      $data = array(':email' => $email);
      // クエリ実行
      queryPost($dbh, $sql, $data);
      // クエリ結果の値を取得
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      debug('クエリ結果の値：'.print_r($result,true));

      // パスワード照合
      if(!empty($result) && password_verify($pass, array_shift($result))){
        debug('パスワードがマッチしました。');

        // ログイン有効期限（デフォルトを１時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time(); //time関数は1970年1月1日 00:00:00 を0として、1秒経過するごとに1ずつ増加させた値が入る

        // ログイン保持にチェックがある場合
        if($pass_save){
          debug('ログイン保持にチェックがあります。');
          // ログイン有効期限を30日にしてセット
          $_SESSION['login_limit'] = $sesLimit * 24 * 30; 
        }else{
          debug('ログイン保持にチェックはありません。');
          // 次回からログイン保持しないので、ログイン有効期限を1時間後にセット
          $_SESSION['login_limit'] = $sesLimit;
        }
        // ユーザーIDを格納
        $_SESSION['user_id'] = $result['id'];

        debug('セッション変数の中身：'.print_r($_SESSION,true));
        debug('マイページへ遷移します。');
        header("Location:mypage.html"); //マイページへ
      }else{
        debug('パスワードがアンマッチです。');
        $err_msg['common'] = MSG09;
      }

    } catch (Exception $e) {
      error_log('エラー発生：' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<')
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>ログイン | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.html">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="login.html">ログイン</a></li>
        <li class="header__link"><a href="signup.html">ユーザー登録</a></li>
      </ul>
    </div>
  </header>

  <!-- ログインフォーム -->
  <div class="site-width">
    <section class="login form-container">
      <form action="mypage.html" method="post" class="login__form">
        <h2 class="login__title title">ログイン</h2>
        <div class="area-msg">
          メールアドレスまたはパスワードが違います
        </div>
        <label>
          メールアドレス
          <input type="text" name="email">
        </label>
        <label>
          パスワード
          <input type="text" name="pass">
        </label>
        <label>
          <input type="checkbox" name="pass_save">次回ログインを省略する
        </label>
          <div class="login__btn-wrap btn-container">
            <input type="submit" class="login__btn btn" value="ログイン">
          </div>
          パスワードを忘れた方は<a href="passRemendSend.html">こちら</a>
      </form>
    </section>
  </div>

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.html">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>
</body>