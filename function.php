<?php
//================================
// ログ
//================================
// ログを取るか
ini_set('log_errors','on');
// ログの出力先ファイルを指定
ini_set('error_log','php.log');

//================================
// デバッグ
//================================
// デバッグフラグ
$debug_flg = true;
// デバッグログ関数
function debug($str){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ：'.$str);
  }
}
//================================
// セッション準備・セッション有効期限を延ばす
//================================
//セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
session_save_path("/var/tmp/");
// ガーベージコレクションが削除するセッションの有効期限を設定（30日以上経っているものに対してだけ１００分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
  debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
  debug('セッションID：'.session_id());
  debug('セッション変数の中身：'.print_r($_SESSION,true));
  debug('偏在日時タイムスタンプ：'.time());
  if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
    debug('ログイン期限日時タイムスタンプ：'.($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}

//================================
// 定数
//================================
// エラーメッセージを定数に代入
define('MSG01','入力必須です');
define('MSG02','Emailの形式で入力してください');
define('MSG03','パスワード（再入力）が合っていません');
define('MSG04','半角英数字のみご利用いただけます');
define('MSG05','6文字以上で入力してください');
define('MSG06','255文字以内で入力してください');
define('MSG07','エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG08','そのEmailは既に登録されています');
define('MSG09','メールアドレスまたはパスワードが違います');
define('MSG10','古いパスワードが違います');
define('MSG11','古いパスワードと同じです');
define('MSG12','文字で入力してください');
define('MSG13','正しくありません');
define('MSG14','有効期限がきれています');
define('MSG15','半角数字のみご利用いただけます');
define('SUC01','パスワードを変更しました');
define('SUC02','プロフィールを変更しました');
define('SUC03','メールを送信しました');
define('SUC04','登録しました');

//================================
// バリデーション関数
//================================
// エラーメッセージ格納用の配列
$err_msg = array();

// バリデーション関数（未入力チェック）
function validRequired($str,$key){
  if($str === ''){ // 金額フォームなどを考えると数値の０はOKにし、空文字はダメにする
    global $err_msg;
    $err_msg[$key] = MSG01; // 入力必須です
  }
}
// バリデーション関数（Email形式チェック）
function validEmail($str,$key){
  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG02; // Emailの形式で入力してください
  }
}
// バリデーション関数（Email重複チェック）
function validEmailDup($email){
  global $err_msg;
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
    $data = array(':email' => $email);
    // クエリ実行
    $stmt = queryPost($dbh,$sql,$data);
    // クエリ結果の値を取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //array_shift関数は配列の先頭を取り出す関数です。クエリ結果は配列形式で入っているので、array_shiftで1つ目だけ取り出して判定します
    if(!empty(array_shift($result))){
      $err_msg['email'] = MSG08; // そのEmailは既に登録されています
    }
  } catch (Exception $e){
    error_log('エラー発生：' . $e->getMessage());
    $err_msg['common'] = MSG07; // エラーが発生しました。しばらく経ってからやり直してください。
  }
}
// バリデーション関数（同値チェック）
function validMatch($str1, $str2, $key){
  if($str1 !== $str2){
    global $err_msg;
    $err_msg[$key] = MSG03; // パスワード（再入力が合っていません）
  }
}
// バリデーション関数（最小文字数チェック）
function validMinLen($str, $key, $min = 6){
  if(mb_strlen($str) < $min){
    global $err_msg;
    $err_msg[$key] = MSG05; // ６文字以上で入力してください
  }
}
// バリデーション関数（最大文字数チェック）
function validMaxLen($str, $key, $max = 255){
  if(mb_strlen($str > $max)){
    global $err_msg;
    $err_msg[$key] = MSG06; // 256文字以上で入力してください
  }
}
// バリデーション関数（半角チェック）
function validHalf($str, $key){
  if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG04; // 半角英数字のみご利用いただけます
  }
}
function validNumber($str, $key){
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG15; // 半角数字のみご利用いただけます
  }
}
// 固定長チェック
function validLength($str, $key, $len = 8){
  if(mb_strlen($str) !== $len){
    global $err_msg;
    $err_msg[$key] = $len . MSG12; // ８文字で入力してください
  }
}
// パスワードチェック
function validPass($str, $key){
  // 半角英数字チェック
  validHalf($str, $key);
  // 最大文字数チェック
  validMaxLen($str, $key);
  // 最小文字数チェック
  validMinLen($str, $key);
}
// selectboxチェック
function validSelect($str, $key){
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG13; // 正しくありません
  }
}
// エラーメッセージを表示
function getErrMsg($key){
  global $err_msg;
  if(!empty($err_msg[$key])){
    return $err_msg[$key];
  }
}

//================================
// データベース
//================================
// DB接続関数
function dbConnect(){
  // DBへの接続準備
  $dsn = 'mysql:dbname=eattoday;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  // PDOオブジェクト生成（DBへ接続）
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}
// SQL実行関数
function queryPost($dbh, $sql, $data){
  // クエリー作成
  $stmt = $dbh->prepare($sql);
  // プレースホルダに値をセットし、SQL文を実行
  if(!$stmt->execute($data)){
    debug('クエリに失敗しました。');
    debug('失敗したSQL：'.print_r($stmt,true));
    $err_msg['common'] = MSG07; //エラーが発生しました。
    return 0;
  }
  debug('クエリ成功。');
  return $stmt;
}
// ユーザー情報取得
function getUser($u_id){
  debug('ユーザー情報を取得します。');
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT * FROM users WHERE id = :u_id AND delete_flg = 0';
    $data = array(':u_id' => $u_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ成功の場合
    // if($stmt){
    //   debug('クエリ成功。');
    // }else{
    //   debug('クエリに失敗しました。');
    // }
    // クエリ結果のデータを１レコード返却
    if($stmt){
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  }catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
  }
  // クエリ結果の値を取得
  // return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getProduct($u_id, $p_id){
  debug('商品情報を取得します。');
  debug('ユーザーID：'.$u_id);
  debug('商品ID：'.$p_id);
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT * FROM product WHERE user_id = :u_id AND id = :p_id AND delete_flg = 0';
    $data = array(':u_id' => $u_id, ':p_id' => $p_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果のデータを１レコード返却
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
  }
}
function getProductList($currentMinNum = 1, $span = 8){
  debug('食べ物情報を取得します。');
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // 件数表示用のSQL文作成
    $sql = 'SELECT id FROM product';
    $data = array();
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    $rst['total'] = $stmt->rowCount(); // 総レコード数
    $rst['total_page'] = ceil($rst['total']/$span); //総ページ数
    if(!$stmt){
      return false;
    }

    // ページング用のSQL文作成
    $sql = 'SELECT * FROM product';
    $sql .= ' LIMIT '.$span. ' OFFSET '.$currentMinNum;
    $data = array();
    debug('SQL：'.$sql);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果のデータを全レコードを格納
      $rst['data'] = $stmt->fetchAll();
      return $rst;
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
  }
}
function getProductOne($p_id){
  debug('食べ物情報を取得します。');
  debug('商品ID：'.$p_id);
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT p.id , p.name , p.recipe , p.comment , p.price , p.pic1 , p.pic2 , p.pic3 , p.user_id , p.create_date , p.update_date , c.name AS category
            FROM product AS p LEFT JOIN category AS c ON p.category_id = c.id WHERE p.id = p_id AND p.delete_flg = 0 AND c.delete_flg = 0';
    $data = array(':p_id' => $p_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果のデータを１レコード返却
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
  }
}
function getCategory(){
  debug('カテゴリー情報を取得します。');
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT * FROM category';
    $data = array();
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果の全データを返却
      return $stmt->fetchAll();
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
  }
}
//================================
// メール送信
//================================
function sendMail($from, $to, $subject, $comment){
  if(!empty($to) && !empty($subject) && !empty($comment)){
    // 文字化けしないように設定（お決まりパターン）
    mb_language("Japanese"); // 現在使っている言語を設定する
    mb_internal_encoding("UTF-8"); // 内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定

    // メール送信（送信結果はtrueかfalseで返ってくる）
    $result = mb_send_mail($to, $subject, $comment, "From: ".$from);
    // 送信結果を判定
    if($result) {
      debug('メールを送信しました。');
    } else {
      debug('【エラー発生】メールの送信に失敗しました。');
    }
  }
}

//================================
// その他
//================================
// サニタイズ
function sanitize($str){
  return htmlspecialchars($str,ENT_QUOTES);
}
// フォーム入力保持
function getFormData($str){
  global $dbFormData;
  global $err_msg;
  // ユーザーデータがある場合
  if(!empty($dbFormData)){
    // フォームのエラーがある場合
    if(!empty($err_msg[$str])){
      // POSTにデータがある場合
      if(isset($_POST[$str])){ //金額や郵便番号などのフォームで数字や数値の0が入っている場合もあるので、issetを使うこと
        return $_POST[$str];
      }else{
        // ない場合（フォームにエラーがある＝POSTされているハズなので、まずありえないが）はDBの情報を表示
        return $dbFormData[$str];
      }
    }else{
      // POSTにデータがあり、DBの情報と違う場合（このフォームも変更していてエラーはないが、他のフォームでひっかかっている状態）
      if(isset($_POST[$str]) && $_POST[$str] !== $dbFormData[$str]){
        return $_POST[$str];
      }else{ // そもそも変更していない
        return $dbFormData[$str];
      }
    }
  }else{
    // データベースに情報がない場合、フォームに入力された値を表示する
    if(isset($_POST[$str])){
      return $_POST[$str];
    }
  }
}
// sessionを１回だけ取得できる（変数dataに内容を入れてSESSIONの内容を削除する）
function getSessionFlash($key){
  if(!empty($_SESSION[$key])){
    $data = $_SESSION[$key];
    $_SESSION[$key] = '';
    return $data;
  }
}
// 認証キー生成
function makeRandkey($length = 8) {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
  $str = '';
  for($i = 0; $i < $length; ++$i) {
    $str .= $chars[mt_rand(0,62)];
  }
  return $str;
}
// 画像処理
function uploadImg($file, $key){
  debug('画像アップロード処理開始');
  debug('FILE情報：'.print_r($file,true));

  if(isset($file['error']) && is_int($file['error'])) {
    try {
      // バリデーション
      // $file['error']の値を確認。配列内には「UPLOAD_ERR_OK」などの定数が入っている。
      // 「UPLOAD_ERR_OK」などの定数はphpファイルアップロード時に自動的に定義される。
      // 定数には値として0や1などの数値が入っている
      switch ($file['error']) {
        case UPLOAD_ERR_OK: // OK
            break;
        case UPLOAD_ERR_NO_FILE:  // ファイル未選択の場合
            throw new RuntimeException('ファイルが選択されていません');
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズが超過した場合
        case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズが超過した場合
            throw new RuntimeException('ファイルサイズが大きすぎます');
        default: // その他の場合
            throw new RuntimeException('その他のエラーが発生しました');
      }

      // $file['mime']の値はブラウザ側で偽装不可能なので、MIMEタイプを自前でチェックする
      // exif_imagetype関数は「IMAGETYPE_GIF」「IMAGETYPE_JPEG」などの定数を返す
      // exif_imagetype関数はエラーになる時があるのでエラーを無視する意味の「@」は必ずつける
      $type = @exif_imagetype($file['tmp_name']);
      // 第三引数にはtrueを設定すると厳密にチェックしてくれるので必ずつける
      if(!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG,], true)) {
          throw new RuntimeException('画像が未対応です');
      }

      // ファイルデータからSHA-1ハッシュを取ってファイル名を決定し、ファイルを保存する
      // ハッシュ化しておかないとアップロードされたファイル名そのままで保存してしまうと同じファイル名が
      // アップロードされる可能性があり、DBにパスを保存した場合、どっちの画像のパスなのか判断つかなくなってしまう
      // image_type_to_extension関数はファイルの拡張子を取得するもの
      $path = 'uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);

      if(!move_uploaded_file($file['tmp_name'], $path)) { // ファイルを移動する
        throw new RuntimeException('ファイル保存時にエラーが発生しました');
      }
      // 保存したファイルパスのパーミッション（権限）を変更する
      chmod($path, 0644);

      debug('ファイルは正常にアップロードされました');
      debug('ファイルパス：'.$path);
      return $path;

    } catch (RuntimeException $e) {

      debug($e->getMessage());
      global $err_msg;
      $err_msg[$key] = $e->getMessage();

    }
  }
}
// ページング
// $currentPageNum : 現在のページ数
// $totalPageNum : 総ページ数
// $link : 検索用GETパラメータリンク
// $pageColNum : ページネーション表示数
function pagination( $currentPageNum, $totalPageNum, $link = '', $pageColNum = 5){
  
}

// 画像表示用関数
function showimg($path){
  if(empty($path)){
    return 'img/sample-img.png';
  }else{
    return $path;
  }
}
// GETパラメータ付与
// $del_key : 付与から取り除きたいGETパラメータのキー
function appendGetParam($arr_del_key){
  if(!empty($_GET)){
    $str = '?';
    foreach($_GET as $key => $val){
      if(!in_array($key,$arr_del_key,true)){ //取り除きたいパラメータじゃない場合にurlにくっつけるパラメータを生成
        $str .= $key.'='.$val.'&';
      }
    }
    $str = mb_substr($str, 0, -1, "UTF-8");
    echo $str;
  }
}