<!-- footer -->
<footer class="footer">
  <div class="footer__inner">
    <p class="footer__text">Copyright <a href="index.php" class="footer__text">WEBサービスOP</a>. All Rights Reserved.</p>
  </div>
</footer>

<!-- javascript -->
<script src="js/vendor/jquery-2.2.2.min.js"></script>
<script>
  $(function() {
    // フッターを最下部に固定
    var $ftr = $('.footer');
    if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
      $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
    }
    // メッセージを表示
    var $jsShowMsg = $('#js-show-msg');
    var msg = $jsShowMsg.text();
    if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
      $jsShowMsg.slideToggle('show');
      setTimeout(function() {
        $jsShowMsg.slideToggle('show');
      }, 5000);
    }
    // 画像ライブプレビュー
    var $dropArea = $('.area-drop');
    var $fileInput = $('.input-file');
    $dropArea.on('click', function(e) {
      e.stopPropagation();
      e.preventDefault();
      $(this).css('border', '3px #ccc dashed');
    });
    $dropArea.on('dragleave', function(e) {
      e.stopPropagation();
      e.preventDefault();
      $(this).css('border', 'none');
    });
    $fileInput.on('change', function(e) {
      $dropArea.css('border', 'none');
      var file = this.files[0], // 2. files配列にファイルが入っています
        $img = $(this).siblings('.prev-img'), // 3. jQueryのsiblingsメソッドで兄弟のimgを取得
        fileReader = new FileReader(); // 4. ファイルを読み込むfileReaderオブジェクト

      // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
      fileReader.onload = function(event) {
        // 読み込んだデータをimgに設定
        $img.attr('src', event.target.result).show();
      };

      // 6. 画像読み込み
      fileReader.readAsDataURL(file);

    });

    // テキストエリアカウント
    $('#comment1,#comment2,#comment3').bind('keyup', function() {
      for (num = 1; num <= 3; num++) {
        var thisValueLength = $('#comment' + num).val().replace(/\s+/g, '').length;
        $("#count" + num).html(thisValueLength);
      }
    });
    // 画像切替
    var $switchImgSubs = $('.js-switch-img-sub'),
        $switchImgMain = $('#js-switch-img-main');
    $switchImgSubs.on('click',function(e){
      $switchImgMain.attr('src',$(this).attr('src'));
    });

    // お気に入り登録・解除
    var $like,
        likeProductId;
    $like = $('.js-click-like') || null; //nullというのはnull値という値で、「変数の中身は空ですよ」と明示するために使う値
    likeProductId = $like.data('productId') || null;
    // 数値の０はfalseと判定されてしまう。product_idが０の場合もありえるので、０もtrueとする場合にはundefinedとnullを判定する
    if(likeProductId !== undefined && likeProductId !== null){
      $like.on('click',function(){
        var $this = $(this);
        $.ajax({
          type: "POST",
          url: "ajaxLike.php",
          data: { productId : likeProductId}
        }).done(function( data ){
          console.log('Ajax Success');
          // クラス属性をtoggleでつけ外しする
          $this.toggleClass('active');
        }).fail(function( msg ) {
          console.log('Ajax Error');
        });
      });
    }
    
  });
</script>