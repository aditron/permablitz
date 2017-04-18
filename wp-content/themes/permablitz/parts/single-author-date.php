<?php
/*  Print the post author. Compatible with Google Structured data. Must be used in the WordPress loop
* @php return html string
/* ------------------------------------ */
$published_date = get_the_date( get_option('date_format') );
?>
<p class="post-byline"><?php _e('by','hueman'); ?>
   <span class="vcard author">
     <span class="fn"><?php the_author_posts_link(); ?></span>
   </span> &middot;
    <?php if ( hu_is_checked('structured-data') ) : ?>
          
              <time class="published" datetime="<?php echo $published_date; ?>"><?php echo $published_date; ?></time>
         
    <?php else : ?>
        <span class="published"><?php echo $published_date; ?></span>
    <?php endif ?>
 </p>