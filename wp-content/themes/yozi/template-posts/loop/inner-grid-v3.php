<?php $thumbsize = !isset($thumbsize) ? yozi_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;?>
<article <?php post_class('post post-layout post-grid-v3'); ?>>
    <?php
        $thumb = yozi_display_post_thumb($thumbsize);
        echo trim($thumb);
    ?>
    <div class="categories"><?php yozi_post_categories($post); ?></div>
    <?php if (get_the_title()) { ?>
        <h4 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
    <?php } ?>
    <?php if (! has_excerpt()) { ?>
        <div class="description"><?php echo yozi_substring( get_the_content(),18, '...' ); ?></div>
    <?php } ?>
</article>