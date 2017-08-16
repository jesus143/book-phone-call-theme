<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div id="page-content">
  <div id="inner-wrapper">
    <h2 class="pageTitle">
      <?php the_title(); ?>
    </h2>
    <div class="post-content">
      <?php the_content(); ?>
    </div>
    <div class="comments-section">
      <?php comments_template(); ?>
    </div>
  </div>
</div>
<?php endwhile; ?>
<?php else : ?>
<div id="page-content">
  <div id="inner-wrapper">
    <h2 class="center">Not Found</h2>
    <p class="center">Sorry, but you are looking for something that isn't here.</p>
    <?php get_search_form(); ?>
  </div>
</div>
<?php endif; wp_reset_query(); ?>
<?php get_footer(); ?>
