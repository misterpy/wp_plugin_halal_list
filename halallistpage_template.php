<?php

/*
Template Name: Halal list
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php

            require_once( $_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php' );

            global $wpdb;

            $result = $wpdb->get_results("Select * from wp_halalList_data");

            ?>

            <article id="post-2" class="post-2 page type-page status-publish hentry">

                <header class="entry-header">
                    <h1 class="entry-title">Halal List</h1>	</header><!-- .entry-header -->

                <div class="entry-content">

                    <ul>

                        <?php

                        foreach($result as $key=>$singleResult){
                            ++$key;
                            echo "<li>
                                <div class='li_dv_header'>Restaurant #$key</div>
                                <div class='li_dv_content dv_hidden'>
                                    Restaurant Name: $singleResult->RestaurantName;<br>
                                    Restaurant Address: $singleResult->Address;<br>
                                    Halal status: $singleResult->HalalStatus;<br>
                                    Meat source: $singleResult->MeatSource;<br>
                                    Alcohol free status: $singleResult->AlcoholFreeStatus;<br>
                                    Pork free status: $singleResult->PorkFreeStatus;<br>
                                    Separate kitchen status: $singleResult->SeparateKitchenStatus;<br>
                                </div>
                            </li>";
                        }

                        ?>

                    </ul>

                </div><!-- .entry-content -->
            </article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
