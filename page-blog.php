<?php get_header(); ?>
<?php
//$paged:現在のページ
// $_GET['key名']:PHPで定義済みの関数。URLの値を受信して処理する関数
$paged = $_GET['pagenum'];
global $NO_IMAGE_URL;
?>
<main class="article">
  <div class="cmn-mv"></div>
  <div class="breadcrumb">
    <?php breadcrumb($post->ID); //パンくずを表示（functions.php）
    ?>
  </div>
  <div class="article-section cmn-section">
    <div class="inner">
      <h2 class="cmn-title">
        <span class="main">ブログ</span>
        <span class="sub">blog</span>
      </h2>
      <div class="article-cont">
        <ul class="article-list">
          <?php
          // クエリ作成用に配列を定義
          $query_args = array(
            'post_status' => 'publish', //投稿ステータスを公開済に指定。誰でも見れる。
            'post_type' => 'post', //投稿記事だけを指定
            'order' => 'DESC', //降順
            'posts_per_page' => 5, //最新記事を5件表示
            'paged' => $paged //サブループに現在何ページ目かを認識させる
          );
          // クエリ作成
          $the_query = new WP_Query($query_args);
          //$the_queryの記事が存在した場合
          if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
              $the_query->the_post(); //ループのインクリメントの役割、これがないと無限ループになるので注意
              // アイキャッチ画像のURLを取得（三項演算子…<条件式> ? <真式> : <偽式>）
              // 条件:アイキャッチ画像が存在するか、真式：存在すればアイキャッチURLを代入、偽式：no-image画像を代入
              $thumbnail = (get_the_post_thumbnail_url($post->ID, 'medium')) ? get_the_post_thumbnail_url($post->ID, 'medium') : get_template_directory_uri() . $NO_IMAGE_URL;
              $title = max_excerpt_length(get_the_title($post->ID), 60); //記事タイトルを取得し、省略される文字数を上限を設定（コードはfunctions.phpを参照）
              $desc = max_excerpt_length(get_the_excerpt($post->ID), 40); //抜粋を取得
              // $data = get_the_modified_date( 'Y-m-d', $post->ID );//更新日を取得
              $data = get_the_time('Y-m-d', $post->ID); //公開日を取得
              $category = get_the_category($post->ID)[0]->name; //カテゴリを取得（並び順で1番目にあるものを1つ）
              $link = get_permalink($post->ID); //投稿記事のURLを取得、get_permalink( 記事ID )
          ?>
              <li class="article-item">
                <a href="<?php echo $link; ?>">
                  <div class="article-text">
                    <p class="time"><time datetime="<?php echo $data; ?>"><?php echo $data; ?></time></p>
                    <div class="title"><?php echo $title; ?></div>
                    <div class="desc"><?php echo $desc; ?></div>
                  </div>
                  <div class="article-image">
                    <?php
                    if ($category) {
                      echo '<p class="category">' . $category . '</p>';
                    };
                    ?>
                    <p class="image"><img src="<?php echo $thumbnail; ?>" alt=""></p>
                  </div>
                </a>
              </li>
          <?php
            endwhile;
          endif;
          wp_reset_query(); //クエリをリセット
          ?>
        </ul>
      </div>
      <div class="article-pager">
        <?php
        $page_url = $_SERVER['REQUEST_URI']; //ページurlを取得
        $page_url = strtok($page_url, '?'); //パラメータは切り捨て
        $the_category_id = null;
        pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url); //ページネーションを表示（functions.php）
        ?>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>