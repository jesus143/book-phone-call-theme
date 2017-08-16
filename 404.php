<?php get_header(); ?>
<div id="page-content">
  <div id="inner-wrapper">
    <div id="pagemain">
      <h1 style="color:#E91B1B; text-align:center">
        <?php _e( 'Sorry, this page is not available!', 'e3ve_nia' ); ?>
      </h1>
      <h2 style="text-align:center">
        <?php _e( 'The page may be broken or may have been removed. Try options below.', 'e3ve_nia' ); ?>
      </h2>
      <center>
      <h2><?php _e( 'Maybe try a search?', 'e3ve_nia' ); ?></h2>
      <div><?php get_search_form(); ?></div>
      </center>
    </div>
    <div id="pagesidebar">
      <?php if ( !function_exists('dynamic_sidebar')
		|| !dynamic_sidebar('Page Sidebar') ) : ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
