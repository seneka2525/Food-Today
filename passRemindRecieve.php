<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>パスワード再発行 | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="signup.php" class="btn-primary">パスワード再発行認証</a></li>
        <li class="header__link"><a href="login.php">ログイン</a></li>
      </ul>
    </div>
  </header>

  <!-- ログインフォーム -->
  <div class="site-width">
    <section class="pass-recieve form-container">
      <form action="passEdit.php" method="post" class="pass-recieve__form">
        <p class="pass-recieve__text">ご指定のメールアドレスにお送りした【パスワード再発行認証】メール内にある「認証キー」をご入力ください。</p>
        <label>
          認証キー
          <input type="text" name="token">
        </label>
        <div class="withdraw__btn-wrap btn-container">
          <input type="submit" class="pass-send__btn btn" value="変更画面へ">
        </div>
      </form>
    </section>
    <a href="passRemindSend.php">&lt; パスワード再発行メールを再度送信する</a>
  </div>

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.php">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>
</body>