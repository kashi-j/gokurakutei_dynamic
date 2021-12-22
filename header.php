<!-- 2～15行の内容はなんとなくの理解でOK！ -->
<!-- ここのコードでクライアントワークが困ることは稀 -->
<?php
    // 変数のスコープ定義
    //グローバル変数（※$postは標準で定義されているらしい）
    global $post,$_HEADER;

    // URLを取得
    //三項演算子で$httpへ代入、is_ssl:現在のリクエストがSSLで行われているか否かを確認する関数
    $http = is_ssl() ? 'https' : 'http' . '://';
    $_HEADER['url'] = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

    //ディスクリプションを取得
    //ここで$_HEADERに代入したものを『メタ情報として使用』
    $_HEADER['description'] = wp_trim_words ( strip_shortcodes( $post->post_content  ), 55 );

    //ogp画像を取得
    $_HEADER['og_image'] = get_the_post_thumbnail_url($post->ID);

    //ページタイトルを取得
    //is_single():単一の投稿（固定ページではない）が表示されている
    //is_page():固定ページが表示されている
    if(is_single() || is_page()) {
        $_HEADER['title'] = (get_the_title($post->ID)) ? get_the_title($post->ID) : get_bloginfo('name');
    } else {
        $_HEADER['title'] = get_bloginfo('name');
    }

    $og_image .= '?' . time(); // UNIXTIMEのタイムスタンプをパラメータとして付与（OGPのキャッシュ対策）
?>
<!DOCTYPE html>
<!-- <html lang="ja"> -->
<html <?php language_attributes(); //html要素のlang属性を出力?>>
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta charset="<?php bloginfo('charset'); //文字エンコーディング情報を出力 ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- 以下、OPG設定（SNSなどの共有時に表示される内容） -->
    <!-- ページのタイトル -->
    <meta property="og:title" content="<?php echo $_HEADER['title']; ?>">
    <!-- ページのタイプ。トップならwebsite or blog,下層ならarticle -->
    <meta property="og:type" content="blog">
    <!-- ツイートに貼り付けられた記事リンクなどをどう見せるか。（4種類） -->
    <meta name="twitter:card" content="summary_large_image" />
    <!-- ページのURL。絶対パスで指定する。 -->
    <meta property="og:url" content="<?php echo $_HEADER['url']; ?>">
    <!-- SNSでシェアされた場合に表示される画像 -->
    <!-- 設定しない場合はページ内の画像からランダムで選ばれる。 -->
    <meta property="og:image" content="<?php echo $_HEADER['og_image'].$og_image; ?>">
    <!-- サイト名 -->
    <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
    <!-- ページの概要として表示される説明文 -->
    <meta property="og:description" content="<?php echo $_HEADER['description']; ?>">
    <!-- ページの内容が何の言葉で記述されているか。必須ではない。 -->
    <meta property="og:locale" content="ja_JP">
<!-- 以上、OPG設定（SNSなどの共有時に表示される内容） -->

    <meta name="description" content="<?php echo $_HEADER['description']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title>Document</title> -->
    <title><?php echo $_HEADER['title'];?></title>
    <!-- SEO内部対策として、URLを正規化する為、canonical属性タグを利用 -->
    <link rel="canonical" href="<?php echo $_HEADER['url']; ?>">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/reset.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- HTML パースの妨害防止でコンテンツの読み込みが高速化される -->
    <script src="<?php echo get_template_directory_uri();?>/js/wow.min.js" defer></script>
    <script src="<?php echo get_template_directory_uri();?>/js/script.js" defer></script>
    <?php wp_head(); //</head>の前には、必ず挿入 ?>
</head>
<body>
    <header class="header">
        <div class="header-fixed">
            <h1 class="header-logo"><a href="<?php echo esc_url(home_url());?>"><img src="<?php echo get_template_directory_uri();?>/image/logo.png" alt="極楽亭"></a></h1>
            <button class="nav-btn" id="nav-btn" type="button" aria-label="メニュー"><span></span><span></span><span></span></button>
        </div>
        <div class="nav header-nav" id="nav">
            <nav class="nav-wrap">
                <ul class="nav-list">
                    <li class="item"><a href="#">宿泊予約</a></li>
                    <li class="item"><a href="#">観光情報</a></li>
                    <li class="item"><a href="#">よくある質問</a></li>
                    <li class="item"><a href="<?php echo esc_url(home_url('/contact')); ?>">お問い合わせ</a></li>
                </ul>
            </nav>
        </div>
    </header>