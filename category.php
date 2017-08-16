<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div id="page-content">
  <div id="inner-wrapper">
    <h2 class="pageTitle">
      <?php the_title(); ?>
    </h2>
    <div class="cat-excerpt-content">
      <?php the_excerpt(); ?>
    </div>
    <?php endwhile; ?>
    <div class="navigation">
      <div class="alignleft">
        <?php next_posts_link('&laquo; Older Entries') ?>
      </div>
      <div class="alignright">
        <?php previous_posts_link('Newer Entries &raquo;') ?>
      </div>
    </div>
  </div>
</div>
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
