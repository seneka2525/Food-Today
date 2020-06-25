<?php

// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「退会ページ」');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================
// post送信されている場合
if(!empty($_POST)){
  debug('POST送信があります。');

  // データベース接続処理
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql1 = 'UPDATE users SET delete_flg = 1 WHERE id = :u_id';
    $sql2 = 'UPDATE product SET delete_flg = 1 WHERE user_id = :u_id';
    $sql3 = 'UPDATE like SET delete_flg = 1 WHERE user_id = :u_id';
    // データ流し込み
    $data = array(':u_id' => $_SESSION['user_id']);
    // クエリ実行
    $stmt1 = queryPost($dbh, $sql1, $data);
    $stmt2 = queryPost($dbh, $sql2, $data);
    $stmt3 = queryPost($dbh, $sql3, $data);

    // クエリ実行成功の場合（最悪userテーブルのみ削除成功していれば良しとする）
    if($stmt1){
      // セッション削除
      session_destroy();
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('トップページへ遷移します。');
      header("Location:index.php");
    }else{
      debug('クエリが失敗しました。');
      $err_msg['common'] = MSG07; // エラーが発生しました。しばらく経ってからやり直してください。
    }

  }catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
    $err_msg['common'] = MSG07; // エラーが発生しました。しばらく経ってからやり直してください。
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<')
?>
<!-- ヘッド -->
<?php
$siteTitle = '退会';
require('head.php');
?>
<body>
  <!-- ヘッダー -->
<?php
require('header.php');
?>

  <!-- 退会フォーム -->
  <div class="site-width">
    <section class="withdraw form-container">
      <form action="" method="post" class="withdraw__form">
        <h2 class="withdraw__title title">退会</h2>
        <div class="withdraw__btn-wrap btn-container">
          <input type="submit" class="withdraw__btn btn" value="退会する" name="submit">
        </div>
      </form>
    </section>
    <a href="mypage.php">&lt; マイページへ戻る</a>
  </div>
  
  <!-- footer -->
  <?php
  require('footer.php');
  ?>
</body>