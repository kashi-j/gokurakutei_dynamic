<?php get_header();?>
  <?php
    global $NO_IMAGE_URL;
  ?>
  <main class="single">
    <div class="breadcrumb">
      <?php breadcrumb( $post->ID );//パンくずを表示(functions.php)?>
    </div>
    <div class="single-section cmn-section">
      <div class="inner">
        <?php
          // 【記事内容を表示】上端
          if( have_posts() ):
            while ( have_posts() ) :
              the_post();
              $title = get_the_title();//記事タイトル
              $content = get_the_content();//記事本文
              $category = get_the_category()[0]->name;//カテゴリを取得（並び順で1番目にあるものを1つ）
              $data = get_the_modified_date( 'Y-m-d', $post->ID );//更新日を取得
              $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
              $thumbID = get_post_thumbnail_id( $post->ID );//アイキャッチのID
              $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);//アイキャッチIDからaltを取得
              $categorys = get_the_category();//カテゴリ
              $categoryList = '';
              // 関連記事を取得する際に使用するクエリの発行に適した形に変更
              // （foreachでループを回し、カンマ区切りの文字列に整形）
              foreach( $categorys as $val ){
                  $categoryList = ($categoryList) ? $categoryList.','.$val->slug : $categoryList.$val->slug;
              };
        ?>
        <header class="single-title">
          <div class="category"><?php echo $category;?></div>
          <h1 class="main"><?php echo $title;?></h1>
        </header>
        <div class="entry">
          <article class="single-entry">
            <div class="wrapper">
              <div class="info">
                <?php
                  // 【SNSボタンを表示】
                  // プラグイン（WP Social Bookmarking Light）で実装
                  if( function_exists('wp_social_bookmarking_light_output_e') ) {
                    wp_social_bookmarking_light_output_e();
                };
                ?>
                <p class="time">
                  <time datetime="<?php echo $data;?>"></time>
                </p>
              </div>
              <div class="body">
                <div class="image">
                  <img src="<?php echo $thumbnail;?>" alt="<?php echo $alt;?>">
                </div>
                <?php
                  echo $content;
                ?>
              </div>
            </div>
          </article>
          <?php
            endwhile;
          else:
            //記事がない場合
            echo 'すみません。お探しの記事は存在しません。';
          endif;
          // 【記事内容を表示】下端
          ?>
          <aside class="single-widget">
            <?php
              // 【関連記事の表示】上端
              $query_args = array(
                'post_status'=> 'publish', //投稿ステータスを公開済に指定。誰でも見れる。
                'post_type'=> 'post', //投稿記事だけを指定
                'order'=>'DESC', //降順
                'posts_per_page'=>5, //最新記事を5件表示
                'orderby'=>'menu_order', //orderby:パラメータで指定した項目の値で投稿をソート munu_order：固定ページの表示順で並び替え
                'category_name'=>$categoryList //カテゴリーのスラッグを指定
              );
              // クエリ作成
              $the_query = new WP_Query( $query_args );
              //$the_queryの記事が存在した場合
              if ( $the_query->have_posts() ) :
            ?>
            <div class="widget-relative widget-section">
              <div class="title">関連記事</div>
              <div class="list">
                <?php
                  while ( $the_query->have_posts() ) :
                    $the_query->the_post();//ループのインクリメントの役割、これがないと無限ループになるので注意
                    $title = get_the_title( $post->ID );//記事タイトル
                    $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
                    $link = get_permalink( $post->ID );//記事url
                ?>
                <div class="item">
                  <a href="<?php echo $link;?>">
                    <div class="image">
                      <img src="<?php echo $thumbnail;?>" alt="">
                    </div>
                    <div class="title">
                      <?php echo $title;?>
                    </div>
                  </a>
                </div>
                <?php
                  endwhile;
                ?>
              </div>
            </div>
            <?php
              endif;
              wp_reset_query();
              // 【関連記事の表示】下端
            ?>

            <?php
              $query_args = array(
                'post_status'=> 'publish',
                'post_type'=> 'post',
                'order'=>'DESC',
                'posts_per_page'=>5,
                'tag'=>'recommend'
              );

              $the_query = new WP_Query( $query_args );
              if ( $the_query->have_posts() ) :
            ?>
            <div class="widget-relative widget-secion">
              <div class="title">おすすめの記事</div>
              <div class="list">
                <?php
                  while( $the_query->have_posts() ):
                    $the_query->the_post();
                    $title = get_the_title( $post->ID );
                    $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : $NO_IMAGE_URL;
                    $link = get_permalink( $post->ID );
                ?>
                <div class="item">
                  <a href="<?php echo $link;?>">
                    <div class="image">
                      <img src="<?php echo $thumbnail;?>" alt="">
                    </div>
                    <div class="title"><?php echo $title;?></div>
                  </a>
                </div>
                <?php
                  endwhile;
                ?>
              </div>
            </div>
            <?php
              endif;
              wp_reset_query();
            ?>
          </aside>
        </div>
      </div>
    </div>
  </main>
<?php get_footer();?>