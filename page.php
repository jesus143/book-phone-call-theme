<?php get_header(); ?>
<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <div id="page-content">
      <div id="inner-wrapper">
        <h2 class="pageTitle">
          <?php the_title(); ?>
        </h2>
        <?php the_content(); ?>
      </div>
    </div>
    <div style="clear:both"></div>
  <?php endwhile; ?>
<?php else : ?>
  <div id="page-content">
    <div id="inner-wrapper">
      <h2 class="center">Not Found</h2>
      <p class="center">Sorry, but you are looking for something that isn't here.</p>
      <?php get_search_form(); ?>
    </div>
  </div>
<?php endif; ?>
<?php get_footer(); ?>