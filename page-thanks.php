<?php get_header();?>
  <main class="contact">
    <div class="cmn-mv"></div>
    <div class="breadcrumb">
      <?php
        breadcrumb( $post->ID );//パンくずを表示（functions.php）
      ?>
    </div>
    <section class="contact-thanks">
      <div class="inner">
        <div class="thanks-text">
          <p>お問い合わせいただきありがとうございます。<br>内容を確認した後に、担当者よりご連絡を差し上げます。</p>
          <div class="link"><a href="/">ホームへ戻る</a></div>
        </div>
      </div>
    </section>
  </main>
<?php get_footer();?>
