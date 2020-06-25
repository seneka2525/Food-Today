<header class="header">
  <div class="header__inner header-width">
    <h1 class="header__logo"><a href="index.php">今日、何食べる？</a></h1>
    <nav class="header__nav">
      <ul class="header__list">
        <?php
        if (empty($_SESSION['user_id'])) {
        ?>
          <li class="header__link"><a href="signup.php">ユーザー登録</a></li>
          <li class="header__link"><a href="login.php">ログイン</a></li>
        <?php
        } else {
        ?>
          <li class="header__link"><a href="mypage.php">マイページ</a></li>
          <li class="header__link"><a href="logout.php">ログアウト</a></li>
        <?php
        }
        ?>
      </ul>
    </nav>
  </div>
</header>
