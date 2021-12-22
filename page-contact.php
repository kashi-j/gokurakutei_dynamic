<?php get_header();?>

  <main class="contact">
    <div class="cmn-mv"></div>
    <div class="breadcrumb">
      <?php
        breadcrumb( $post->ID );
      ?>
    </div>
    <div class="contact-section cmn-section">
      <div class="formarea">
        <h2 class="cmn-title">
          <span class="main">お問い合わせ</span>
          <span class="sub">Contact</span>
        </h2>
        <div class="contact-form">
          <?php
            while(have_posts()){
              the_post();
              the_content();
            }
          ?>
        </div>
      </div>
    </div>
  </main>
<?php get_footer();?>