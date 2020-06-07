<?php

// 共通変数・関数ファイル読み込み
require('function.php');

// post送信されている場合
if(!empty($_POST)){

  // 変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_re = $_POST['pass_re'];

  // 未入力チェック
  validrequired($email,'email');
  validrequired($pass,'pass');
  validrequired($pass_re,'pass_re');

  // エラーメッセージがない場合
  if(empty($err_msg)){

    // emailの形式チェック
    validEmail($email,'email');
    // emailの最大文字数チェック
    validMaxLen($email,'email');
    // email重複チェック
    validEmailDup($email);

    // パスワードの半角英数字チェック
    validHalf($pass,'pass');
    // パスワードの最大文字数チェック
    validMaxLen($pass,'pass');
    // パスワードの最小文字数チェック
    validMinLen($pass,'pass');

    // パスワード（再入力）の最大文字数チェック
    validMaxLen($pass_re,'pass_re');
    // パスワード（再入力）の最小文字数チェック
    validMinLen($pass_re,'pass_re');

    // エラーメッセージがない場合
    if(empty($err_msg)){

      // パスワードとパスワード再入力が合っているかチェック
      validMatch($pass,$pass_re,'pass_re');

      // エラーメッセージがない場合
      if(empty($err_msg)){
        debug('バリデーションOKです!!');

        // ユーザーを登録するため、データベースへ接続する
        // 例外処理
        try {
          $dbh = dbConnect();
          // SQL文作成
          $sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
          $data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                        ':login_time' => date('Y-m-d H:i:s'),
                        ':create_date' => date('Y-m-d H:i:s'));
          // クエリ実行
          queryPost($dbh, $sql, $data);
          debug('ユーザーを登録しました。');

          // マイページへ遷移
          header('Location:mypage.php');

        } catch (Exception $e){
          error_log('エラー発生：' . $e->getMessage);
          $err_msg['common'] = MSG07;
        }

      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>ユーザー登録 | 今日、何食べる？</title>
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

  <!-- 登録フォーム -->
  <div class="site-width">
      <section class="signup form-container">
        <form action="" method="post" class="signup__form">
          <h2 class="signup__title title">ユーザー登録</h2>
          <div class="area-msg">
            <!-- phpのエラー表示用スタイル追加 -->
          </div>
          <label class="">
            Email
            <input type="text" name="email" value="">
          </label>
          <div class="area-msg">
            <!-- phpのエラー表示用スタイル追加 -->
          </div>
          <label class="">
            パスワード <span>※英数字６文字以上</span>
            <input type="password" name="pass" value="">
          </label>
          <div class="area-msg">
            <!-- phpのエラー表示用スタイル追加 -->
          </div>
          <label class="">
            パスワード（再入力）
            <input type="password" name="pass_re" value="">
          </label>
          <div class="area-msg">
            <!-- phpのエラー表示用スタイル追加 -->
          </div>
          <div class="signup__btn-wrap btn-container">
            <input type="submit" class="signup__btn btn" value="登録する">
          </div>
        </form>
      </section>
  </div>
  
  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.php">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>
</body>