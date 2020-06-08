<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="dest/bundle.css">
  <link rel="stylesheet" href="text/css" href="style.css">
  <title>料理登録 | 今日、何食べる？</title>
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner header-width">
      <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
      <ul class="header__list">
        <li class="header__link"><a href="mypage.php">マイページ</a></li>
        <li class="header__link"><a href="logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header>

  <!-- パスワード変更フォーム -->
  <div class="site-width">
    <div class="page-title-wrap">
      <h1 class="page-title title">料理を登録する</h1>
    </div>
    <section class="product-edit form-container">
      <form action="mypage.php" method="post" class="product-edit__form">
        <div class="area-msg">
          金額には数字を入力してください<br>
          料理名が長すぎます<br>
          レシピは500文字までです
        </div>
        <label>
          料理名
          <input type="text" name="name">
        </label>
        <label>
          カテゴリ
          <select name="category" id="">
            <option value="1">和食</option>
            <option value="2">中華</option>
          </select>
        </label>
        <label>
          レシピ
          <textarea name="recipe" id="" cols="30" rows="10"></textarea>
        </label>
        <p class="counter-text">0/500文字</p>
        <label>
          詳細
          <textarea name="comment" id="" cols="30" rows="10"></textarea>
        </label>
        <p class="counter-text">0/500文字</p>
        <label>
          金額
          <div class="product-edit__price">
            <input type="text" name="price"><span class="option">円</span>
          </div>
        </label>
        <label>
          画像１
          <div class="area-drop">
            ここに画像をドラッグ＆ドロップ
          </div>
        </label>
        <label>
          画像２
          <div class="area-drop">
            ここに画像をドラッグ＆ドロップ
          </div>
        </label>
        <label>
          画像３
          <div class="area-drop">
            ここに画像をドラッグ＆ドロップ
          </div>
        </label>

        <div class="product-edit__btn-wrap btn-container">
          <input type="submit" class="product-edit__btn btn" value="登録する">
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
</body>