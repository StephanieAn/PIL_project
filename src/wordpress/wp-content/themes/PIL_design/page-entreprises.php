<? 
/*
* Template Name: Archives
*/
?>

<? get_header(); ?>

<?php 
// 1. On définit les arguments pour définir ce que l'on souhaite récupérer
$args = array(
    'post_type' => 'post',
    'category_name' => 'films',
    'posts_per_page' => 3,
);

// 2. On exécute la WP Query
$my_query = new WP_Query( $args );

// 3. On lance la boucle !
if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    
    the_title();
    the_content();
    the_post_thumbnail();

endwhile;
endif;

// 4. On réinitialise à la requête principale (important)
wp_reset_postdata();

?>






<section class="secteurs">
        <div class="gauche">
                <h1><? the_title();?></h1>
                
                <ul>   
        <?php 
            $get_parent_cats = array(
                'parent' => '0' //get top level categories only
            ); 

            $all_categories = get_categories( $get_parent_cats );//get parent categories 

            foreach( $all_categories as $single_category ){
                //for each category, get the ID
                $catID = $single_category -> cat_ID;

                echo '<li><a href=" ' . get_category_link( $catID ) . ' ">' . $single_category -> name . '</a>'; //category name & link
                 echo '<ul class="post-title">';

                $query = new WP_Query( array( 'cat'=> $catID, 'posts_per_page'=>10 ) );
                while( $query->have_posts() ):$query->the_post();
                 echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                endwhile;
                wp_reset_postdata();

                echo '</ul>';
                $get_children_cats = array(
                    'child_of' => $catID //get children of this parent using the catID variable from earlier
                );

                $child_cats = get_categories( $get_children_cats );//get children of parent category
                echo '<ul class="children">';
                    foreach( $child_cats as $child_cat ){
                        //for each child category, get the ID
                        $childID = $child_cat -> cat_ID;

                        //for each child category, give us the link and name
                        echo '<a href=" ' . get_category_link( $childID ) . ' ">' . $child_cat->name . '</a>';

                         echo '<ul class="post-title">';

                        $query = new WP_Query( array( 'cat'=> $childID, 'posts_per_page'=>10 ) );
                        while( $query -> have_posts() ):$query -> the_post();
                         echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                        endwhile;
                        wp_reset_postdata();

                        echo '</ul>';

                    }
                echo '</ul></li>';
            } //end of categories logic ?>
    </ul>

        </div>

        <div class="droite">
                <?php 
                // the query
                $wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish')); ?>
                
                <?php if ( $wpb_all_query->have_posts() ) : ?>

                        <form role="search" method="post" id="searchform" class="searchform" action="http://localhost/wordpress/index.php/les-entreprises/?s=<? the_field('nom_entreprise');?>">
                                <label class="screen-reader-text" for="s">Search for:</label>
                                <input type="text" value="" name="s" id="s" placeholder="Chercher une entreprise"/>
                                <input type="submit" id="searchsubmit" value="Search"/>
                         </form> 

                        <!-- the loop -->
                        <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
                        <div class="secteur__entreprise">
                                <button class="secteur__accordion">
                                        <div class="secteur__titre">
                                                <h2><? the_field('nom_entreprise')?></h2>
                                                <?php foreach(get_field('taxonomie_entreprise') as $data){ ?>
                                                        <h6> <?php echo $data;?></h6>
                                                <? }?>
                                        </div>
                                        <img class="secteur__btn" src="http://localhost/wordpress/wp-content/uploads/2021/09/arrow-down.svg" alt="button flèche vers le bas">
                                </button>            
                                <div class="secteur__panel">
                                        <img class="secteur__img" src="<? the_field('image_entreprise')?>" alt="<? the_field('nom__entreprise')?>">
                                        <div class="secteur__info">
                                                <h6><? the_field('telephone_entreprise')?></h6>
                                                <h6><? the_field('email_entreprise')?></h6>
                                                <h6>
                                                        <a href="<? the_field('site_web_entreprise')?>">
                                                        <? the_field('site_web_entreprise')?>
                                                        </a>
                                                </h6>
                                                <p><? the_field('description_entreprise')?></p>
                                        </div>
                                </div>
                        </div>
                <?php endwhile; ?>
                <!-- end of the loop -->                
                <?php wp_reset_postdata(); ?>
                <?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>                        
        </div>
</section>

<? get_footer(); ?>