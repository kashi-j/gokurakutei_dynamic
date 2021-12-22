<?php
// $NO_IMAGE_URLをどこでも使えるようにする
// $NO_IMAGE_URL…アイキャッチが存在しなかった際に表示される画像のURLを格納
global $NO_IMAGE_URL;
$NO_IMAGE_URL= '/image/noimg.png';
add_theme_support('post-thumbnails');//アイキャッチを有効にする

// // カスタムメニュー機能を使用可能にする
// add_theme_support('menus');

/*文字数の設定（第1引数：加工する文章、第2引数：文字数）
------------------------------------------------------*/
function max_excerpt_length( $string, $maxLength) {
  $length = mb_strlen($string, 'UTF-8');
  if($length < $maxLength){
    return $string;
  } else {
    $string = mb_substr( $string , 0 , $maxLength, 'utf-8' );
    return $string.'[...]';
  }
}



/*ページネーション
---------------------------------------------------------*/
/*
使い方↓
$page_url = $_SERVER['REQUEST_URI'];//ページurlを取得
$page_url = strtok( $page_url, '?' );//パラメータは切り捨て
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);

引数↓
@ $pages =>     ページ数
@ $term_id =>   タクソノミーID
@ $paged =>     現在のページ
@ $page_url =>  ページURL
@ $range =>     前後に何ページ分表示するか（引数が無ければ2ページ表示する）
*/
// function 関数名(引数)｛処理｝
function pagination( $pages, $term_id, $paged, $page_url, $range = 2) {

  $pages = ( int ) $pages;//全てのページ数。float型で渡ってくるので明示的に int型 へ
  $paged = $paged ?: 1;//現在のページ
  $term_id = ( $term_id ) ? $term_id : 0;//タームID
  $s = $_GET['s'];//検索ワードを取得
  $search = ($s) ? '&s='.$s : '';//検索パラメータを制作

  if ($pages === 1 ) {
      // 1ページ以上の時 => 出力しない
      return;
  };

  if ( 1 !== $pages ) {
      //２ページ以上の時
      echo '<div class="inner">';
      if ( $paged > $range + 1 ) {
				// 一番初めのページへのリンク
				echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
        echo '<div class="dots"><span>...</span></div>';
			};
      for ( $i = 1; $i <= $pages; $i++ ) {
        //ページ番号の表示
        if ( $i <= $paged + $range && $i >= $paged - $range ) {
          if ( $paged == $i ) {
            //現在表示しているページ
            echo '<div class="number -current"><span>'.$i.'</span></div>';
          } else {
            //前後のページ
            echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
          };
        };
      };
      if ( $paged < $pages - $range ) {
				// 一番最後のページへのリンク
        echo '<div class="dots"><span>...</span></div>';
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='. $pages.$search.'"><span>'. $pages .'</span></a></div>';
      }
      echo '</div>';
  };
};



/*パンくず
--------------------------------------------------------- */
function breadcrumb($postID) {
  // $title = get_the_title($postID);//記事タイトル
  $title = max_excerpt_length(get_the_title ($postID), 30);//記事タイトル
  echo '<ol class="breadcrumb-list">';
  if ( is_single() ) {
    //詳細ページの場合
    echo '<li class="breadcrumb-item"><a href="../../">ホーム</a></li>';
    echo '<li class="breadcrumb-item"><a href="../blog/">ブログ記事一覧</a></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
  }
  else if( is_page() ) {
    //固定ページの場合
    echo '<li class="breadcrumb-item"><a href="../">ホーム</a></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
  }
  echo "</ol>";
}