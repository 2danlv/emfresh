<?php if (get_field( "related_page" ) != '') : foreach (get_field( "related_page" ) as $key => $related_page) : ?>
  <li class="menu-item has-child <?= ($related_page->ID == get_the_ID()) ? 'submenu-show current-item' : '' ?>">
    <a class="nav-link"><?= $related_page->post_title ?></a>
    <?php if( have_rows('page_content', $related_page->ID) ): while ( have_rows('page_content', $related_page->ID) ) : the_row(); ?>
    <?php if( have_rows('section', $related_page->ID) ) : ?>
      <img src="<?php site_the_assets('img/common/icon_down.png') ?>" alt="">
      <ul class="submenu">
        <?php while( have_rows('section', $related_page->ID) ): the_row(); ?>
        <li><a href="<?= get_page_link($related_page->ID).'#section_'.get_row_index();?>" rel="#section_<?= get_row_index() ?>">
          <?= the_sub_field('title', $related_page->ID); ?>
        </a></li>
        <?php endwhile; // end loop section?>
      </ul>
    <?php endif; //if exit section?>
    <?php endwhile; endif; //end if exit page_content?>
  </li>
<?php endforeach; endif //End loop related page?>
