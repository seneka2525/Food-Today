<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>パスワード変更 | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="mypage.php">マイページ</a></li>
        <li class="header__link"><a href="">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <!-- パスワード変更フォーム -->
  <div class="site-width">
    <div class="page-title-wrap">
      <h1 class="page-title title">パスワード変更</h1>
    </div>
    <section class="pass-edit form-container">
      <form action="" method="post" class="pass-edit__form">
        <div class="area-msg">
          古いパスワードが正しくありません。<br>
          新しいパスワードと新しいパスワード（再入力）が一致しません。<br>
          新しいパスワードは半角英数字6文字以上で入力してください。<br>
          パスワードが長すぎます。
        </div>
        <label>
          古いパスワード
          <input type="text" name="pass_old">
        </label>
        <label>
          新しいパスワード
          <input type="text" name="pass_new">
        </label>
        <label>
          新しいパスワード（再入力）
          <input type="text" name="pass_new_re">
        </label>
        <div class="pass-edit__btn-wrap btn-container">
          <input type="submit" class="pass-edit__btn btn" value="変更する">
        </div>
      </form>
    </section>

    <!-- サイドバー -->
    <aside class="content__2column">
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

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__inner">
      <p class="footer__text">Copyright <a href="index.php">WEBサービスOP</a>. All Rights Reserved.</p>
    </div>
  </footer>
</body>