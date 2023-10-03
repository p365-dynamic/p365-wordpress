<?php

if ( ! function_exists('custom_post_type') ) {

	// Register Custom Post Type
	function custom_post_type() {
	
		$labels = array(
			'name'                  => _x( 'Product Videos', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Product Video', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Product Videos', 'text_domain' ),
			'name_admin_bar'        => __( 'Product Video', 'text_domain' ),
			'archives'              => __( 'Item Archives', 'text_domain' ),
			'attributes'            => __( 'Item Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Items', 'text_domain' ),
			'add_new_item'          => __( 'Add New Item', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Item', 'text_domain' ),
			'edit_item'             => __( 'Edit Item', 'text_domain' ),
			'update_item'           => __( 'Update Item', 'text_domain' ),
			'view_item'             => __( 'View Item', 'text_domain' ),
			'view_items'            => __( 'View Items', 'text_domain' ),
			'search_items'          => __( 'Search Item', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Video Snapshot', 'text_domain' ),
			'set_featured_image'    => __( 'Set video snapshot', 'text_domain' ),
			'remove_featured_image' => __( 'Remove video snapshot', 'text_domain' ),
			'use_featured_image'    => __( 'Use as video snapshot', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);
		$capabilities = array(
			'edit_post'             => 'edit_product_video',
			'read_post'             => 'read_product_video',
			'delete_post'           => 'delete_product_video',
			'edit_posts'            => 'edit_product_video',
			'edit_others_posts'     => 'edit_product_video',
			'publish_posts'         => 'publish_product_video',
			'read_private_posts'    => 'read_private_product_video',
		);
		$args = array(
			'label'                 => __( 'Product Video', 'text_domain' ),
			'description'           => __( 'Product Videos', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-format-video',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capabilities'          => $capabilities,
			'show_in_rest'          => false,
		);
		register_post_type( 'product_video', $args );
	
	}
	add_action( 'init', 'custom_post_type', 0 );
	
	}
	
add_action( 'wp_ajax_updatelikes', 'updatelikes' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_updatelikes', 'updatelikes' );
function updatelikes(){
	$id = $_POST['post_id'];
	$liketype = $_POST['type'];
	$current = $_POST['current'];
	$current = $current+1;
	if($liketype == 'upvote'){
		update_field('upvote', $current, $id);
	}
    else{
		update_field('downvote', $current, $id);
	}
	print_r($current);
	wp_die();
}

add_action( 'wp_ajax_remove_creative', 'remove_creative' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_remove_creative', 'remove_creative' );
function remove_creative(){
	$userInfo = $_POST['userInfo'];
	$campaignId = $_POST['campaignId'];
	$affiliateID = $_POST['affid'];
	$campaignLinks = get_user_meta($userInfo, 'campaignsid', true);
	$campaignLinks = explode(',',$campaignLinks);
	//print_r($campaigns);
	//print_r($campaignLinks);
	print_r($campaignLinks);
	$arrkey = array_search($campaignId, $campaignLinks);
	unset($campaignLinks[$arrkey]);
	$campaignLinks = array_values($campaignLinks);
	print_r($campaignLinks);
	$campaignLinks = implode(',',$campaignLinks);

	print_r($campaignLinks);
    update_user_meta($userInfo, 'campaignsid', $campaignLinks, false );
		// echo "<div id='message' class='updated'><p>Campaign assigned to user successfully!</p></div>";
		$header = array(
			"header" => array(	"deviceId" => "ABCD12345",
			"transactionName" => "updateAffiliate"),
			"body"=> array("action"=>"UPDATE",  
			"deviceId"=>$affiliateID,
			"campaignId"=>$campaignLinks
			)
		 );
		 $jsonEncodedheader = json_encode($header);
		 $args = array(
				 'method' => 'POST',
				'timeout' => 45,
				 'redirection' => 5,
				 'httpversion' => '1.0',
				'headers' => array("Content-type" =>"application/json;charset=UTF-8"),
				// 'blocking' => true,
				// 'sslverify' => false,
				'body' => $jsonEncodedheader,
				'cookies' => array()
		);
		
	// $updresponse = wp_remote_post( 'http://192.168.0.10:8181/cxf/authrestservices/integrate/invoke', $args);
	print_r($_POST);
	wp_die();
}


add_action( 'wp_ajax_make_booking', 'make_booking' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_make_booking', 'make_booking' );


function make_booking(){
	$type = $_POST['type'];
	$date = $_POST['datedata'];
	$range = $_POST['rangeflag'];
	$formdate = $_POST['fromr'];
	$todate = $_POST['tor'];
	$affiliateid =$_POST['affiliateid'];
	$username = "leadpush";
	$password = "308973632c20b57f30e89dfcf1c21e04";
	
	$parameters = array(
		"user_auth" => array(
		"user_name" => $username,
		"password" => $password,
		"version" => "1"
		),
		"application_name" => "test",
		"name_value_list" => array(),
		);
	$jsonEncodedData = json_encode($parameters);

$post = array(
"method" => 'login',
"input_type" => "JSON",
"response_type" => "JSON",
"rest_data" => $jsonEncodedData
);

$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'headers' => array(),
			'blocking' => true,
			'sslverify' => false,
			'body' => $post,
			'cookies' => array()
);
$response = wp_remote_post( 'http://uatcrm.policies365.com/service/v4_1/rest.php', $args);
//print_r($response['body']);
//$resp = explode("\r\n\r\n", $response, 2);
$resp1 = json_decode($response['body']);
$linkid = $resp1->id;
if($affiliateid=='none'){
if($range == '1'){
	$replink='<a href="http://uatcrm.policies365.com/index.php?entryPoint='.$type.'&from='.$formdate.'&to='.$todate.'&getReport=1&range=1&MSID='.$linkid.'" id="feedback" class="button-primary">Download</a>';
}else{
$replink='<a href="http://uatcrm.policies365.com/index.php?entryPoint='.$type.'&date='.$date.'&getReport=1&MSID='.$linkid.'" id="feedback" class="button-primary">Download</a>';
}
}
else{
	if($range == '1'){
		$replink='<a href="http://uatcrm.policies365.com/index.php?entryPoint='.$type.'&from='.$formdate.'&to='.$todate.'&getReport=1&range=1&affiliateid='.$affiliateid.'&MSID='.$linkid.'" id="feedback" class="btn btn-info btn-lg">Download</a>';
	}else{
	$replink='<a href="http://uatcrm.policies365.com/index.php?entryPoint='.$type.'&date='.$date.'&getReport=1&affiliateid='.$affiliateid.'&MSID='.$linkid.'" id="feedback" class="btn btn-info btn-lg">Download</a>';
	}	
}
print_r($replink);
wp_die();
}

function cm_redirect_users_by_role() {
 
    $current_user   = wp_get_current_user();
    $role_name      = $current_user->roles[0];
 
    if ( is_user_logged_in() && current_user_can( 'wpam_affiliate' )) {
        wp_redirect(home_url( '/affiliate-home/' ));
    } // if
 
} // cm_redirect_users_by_role


add_action( 'admin_init', 'cm_redirect_users_by_role' );
//for angular init
function angular_matter()
{
	global $post;
    $post_slug=$post->post_name;
	if( is_user_logged_in() && current_user_can( 'administrator' ) ) {
		return;
	}
	else{
			wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.css' ));
		// <script src="flat-visual-chat/flat-visual-chat.js');
	}
}
add_action( 'wp_enqueue_scripts', 'angular_matter');


	//End angular

	//create a false shortcode for testimonial starts
	
	//Styles
    function slick_slider_styles(){
		// wp_enqueue_script('jQueryMain', get_template_directory_uri() .'/app/common/js/ui/jquery.js');
      	wp_enqueue_style( 'slick', get_theme_file_uri( '/css/slick.css' ));
		wp_enqueue_style( 'testimonial_stars', get_theme_file_uri( '/css/testimonial_stars.css' ));
    }
    add_action( 'wp_enqueue_scripts', 'slick_slider_styles');

    //Scripts
    function slick_slider_js(){
        wp_enqueue_script( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js', array('jquery'), '1.5.0', true );
		wp_enqueue_script( 'slickjs_init', get_template_directory_uri() .'/js/slick_init.js', array( 'slick' ), '', true );
		wp_enqueue_script( 'bootstrap_js', get_template_directory_uri() .'/js/bootstrap.min.js', array( 'jquery' ), '', true );
	}
	
    add_action( 'wp_enqueue_scripts', 'slick_slider_js');
	
	function testslider_func() {
		$loop = new WP_Query( array( 'post_type' => 'testimonial', 'ignore_sticky_posts' => 0, 'paged' => $paged ) );
		if ( $loop->have_posts() ) : 
		//print_r($loop);
		?>
		<div class="slider-for">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<div class="testimonial_slide">
				<div class="testimonial_slide_inner">
				<div class="row tittle_row">
					<div class="testimonial_title col-xs-6 col-sm-6 col-md-6">
						<h5><div class="nospace"><?php echo get_the_title(); ?></div></h5>
					</div>
					<div class="testimonial_rating col-xs-6 col-sm-6 col-md-6">
					<div style="float:left; width:auto; display:inline-block;">
						<h5>Rating </h5>
						<?php //the_field( 'Rating' );
						$rate = get_field( 'Rating' ); 
						$stars = $rate * 20;
						//echo $stars;
						?>
					</div>
					<div style="float:left; width:auto; display:inline-block; padding-left:10px;line-height: 20px;">
					<div class="star-rating" title="<?php echo $rate.' star rating';?>">
					<div class="back-stars">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
			
					<div class="front-stars" style="width: <?php echo $stars;?>%">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
					</div>
					</div>
					</div>    
					
					</div>
					</div>
				</div>
				<div class="row desc_row"> 
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="testimonial_user_image  col-xs-4 col-sm-4 col-md-4">
							<?php the_post_thumbnail(); ?>
					</div>
					<div class="testimonial_user_text  col-xs-8 col-sm-8 col-md-8">
							<?php the_content(); ?>
					</div>
					<?php } ?>
				</div>
				</div>
				</div>
		<?php endwhile; ?>
		</div>	
		<?php endif;
		wp_reset_postdata();
		//return "hello this is my testimonial slider!";
		}
	add_shortcode( 'testimonial_slider', 'testslider_func' );

   //shortcode ends
   

	//review slider starts new theme
	
	
	function review_func() {
		$loop = new WP_Query( array( 'post_type' => 'testimonial', 'ignore_sticky_posts' => 0, 'paged' => $paged ) );
		if ( $loop->have_posts() ) : 
		//print_r($loop);
		?>
		<section class="center_review slider">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<div>    
<div class="slide_inner_container">
	<div class="img"><?php the_post_thumbnail(); ?></div>
	<div class="title_text"><?php echo get_the_title(); ?></div>
	<?php //the_field( 'Rating' );
						$rate = get_field( 'Rating' ); 
						$stars = $rate * 20;
						//echo $stars;
						?>
	<div class="star_rating" title="<?php echo $rate.' star rating';?>">
					<div class="back-stars">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
			
					<div class="front-stars" style="width: <?php echo $stars;?>%">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
					</div>
					</div>
					</div>
	<div class="review_desc"><?php the_content(); ?></div>
</div>
</div>
				
		<?php endwhile; ?>
		</section>	
		<?php endif;
		wp_reset_postdata();
		//return "hello this is my testimonial slider!";
		}
	add_shortcode( 'review_slider', 'review_func' );
	
	
	//review slider ends
	function Product_Videos( $atts, $paged = null ) {
		$cat = $atts['cat'];
		$cat_id = get_cat_id($cat);
		$loop = new WP_Query( array( 'post_type' => 'product_video', 'ignore_sticky_posts' => 0, 'cat'=> $cat_id,'paged' => $paged ) );
		if ( $loop->have_posts() ) : ?>
		<section class="product_video">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 card_col">
                        <div class="card">
						<div class="image-container_vid">
						<?php the_post_thumbnail(); ?>
    					<div class="vid_overlay">                                
							<h3><?php echo get_the_title(); ?>
                                    <span class="video_toggle" data-toggle="modal" data-target="#modal-video-<?php the_Id()?>" video-attr="#video-<?php the_Id()?>"><i class="fa fa-play-circle-o"></i>Play video</span>
                            </h3></div>
						</div>
                            <div class="overview-container-vid">
								<div class="vid_exerpt"><?php the_content(); ?></div>


                                <p class="vid_readmore"><a id="card-link" data-toggle="modal" data-target="#modal-content-<?php the_Id()?>"><span class="card-link">Read More</span></a></p>
                                <div class="rating-div1">
                                    <p class="rating-value" id="upvote-<?php the_Id()?>"><?php the_field('upvote'); ?></p>
                                    <p class="rating-text rating-success">Helpful</p>
                                </div>
                                <div class="rating-div2">
                                    <p class="rating-value rating-normal" id="downvote-<?php the_Id()?>"><?php the_field('downvote'); ?></p>
                                    <p class="rating-text rating-normal">Not Helpful</p>
                                </div>
                            </div>
                        </div>
                    </div>
   

    <!-- Modal for video -->

    <div id="modal-video-<?php the_Id()?>" class="modal fade modal-video" video-attr="#video-<?php the_Id()?>" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle-o"></i></button>
                </div>
                <div class="modal-body">
				<video id="video-<?php the_Id()?>" src="<?php the_field('video_self_hosted_url'); ?>" controls preload="none">
				<source type="video/mp4" src="<?php the_field('video_self_hosted_url'); ?>">
    			<a href="<?php the_field('video_self_hosted_url'); ?>"></a>
				</video>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for read-more content -->

    <div id="modal-content-<?php the_Id()?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
			<div class="modal-header vid_desc_head">
			<?php echo get_the_title(); ?>
			<button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#modal-like-<?php the_Id()?>"><i class="fa fa-times-circle-o"></i></button>
			</div>
                <div class="modal-body vid_desc_body">
                    
					<?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for like & dislike data -->

    <div id="modal-like-<?php the_Id()?>" class="modal fade modal-like">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
				<div class="circular-link like-link close" data-dismiss="modal" id="<?php the_Id()?>" type="upvote" current="<?php the_field('upvote'); ?>"><i class="fa fa-thumbs-up"></i></div>
				<div class="circular-link unlike-link close" data-dismiss="modal" id="<?php the_Id()?>" type="downvote" current="<?php the_field('downvote'); ?>"><i class="fa fa-thumbs-down"></i></div>
                </div>
            </div>
        </div>
    </div>

		<?php endwhile; ?>
		</section>	
		<?php endif;
		wp_reset_postdata();
		}
	add_shortcode( 'Product_Videos', 'Product_Videos' );
	

   //custom redirect 404
	add_action( 'template_redirect', 'unlisted_404_redirect' );
	function unlisted_404_redirect()
	{
    // check if is a 404 error
    if( is_404() )
    {
        // then redirect to yourdomain.com/jobs/
        wp_redirect( home_url( '/page-not-found/' ) );
        exit();
    }
	}
	//custom redirect end	
	
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}


add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
//global $wp_meta_boxes;
	$current_user   = wp_get_current_user();
	$role_name      = $current_user->roles[0];
	$role_name1      = $current_user->roles[1];
 
    if ( 'affiliate_manager' === $role_name || 'affiliate_manager' === $role_name1 ) {
		wp_add_dashboard_widget('custom_help_widget', 'Affiliate Manager', 'custom_dashboard_help');
		//print_r($wp_meta_boxes);
	}
	if ( 'chat_manager' === $role_name || 'chat_manager' === $role_name1 ) {
		wp_add_dashboard_widget('custom_help_widget', 'Chat Manager', 'custom_dashboard_help_cm');
		//print_r($wp_meta_boxes);
	}
	if ( 'chat_agent' === $role_name || 'chat_agent' === $role_name1 ) {
		wp_add_dashboard_widget('custom_help_widget', 'Chat Agent', 'custom_dashboard_help_ca');
		//print_r($wp_meta_boxes);
    }   
	// print_r($current_user->roles);
	// die();
}

function login_redirect( $redirect_to, $request, $user ){
	$role_name      = $user->roles[0];
	$role_name1      = $user->roles[1];
	if ( 'chat_manager' === $role_name || 'chat_manager' === $role_name1 ) {
	return admin_url('admin.php?page=wplivechat-menu', 'http');
	}
	elseif ( 'chat_agent' === $role_name || 'chat_agent' === $role_name1 ) {
	return admin_url('admin.php?page=wplivechat-menu', 'http');
    }else{
	return $redirect_to;
	}
  }
  add_filter( 'login_redirect', 'login_redirect', 10, 3 );

add_action('admin_init', 'dash_customs');
function dash_customs() {
//global $wp_meta_boxes;
	$current_user   = wp_get_current_user();
	$role_name      = $current_user->roles[0];
	$role_name1      = $current_user->roles[0];
 
    if ( 'affiliate_manager' === $role_name || 'affiliate_manager' === $role_name1 ) {
		echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none !important;}</style>';
		// wp_add_dashboard_widget('custom_help_widget', 'Affiliate Manager', 'custom_dashboard_help');
		//print_r($wp_meta_boxes);
	}
	if ( 'chat_manager' === $role_name || 'chat_manager' === $role_name1 ) {
		echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none !important;}</style>';
		// wp_add_dashboard_widget('custom_help_widget', 'Chat Manager', 'custom_dashboard_help_cm');
		//print_r($wp_meta_boxes);
	}
	if ( 'chat_agent' === $role_name || 'chat_agent' === $role_name1 ) {
		echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none !important;}</style>';
		// wp_add_dashboard_widget('custom_help_widget', 'Chat Agent', 'custom_dashboard_help_ca');
		//print_r($wp_meta_boxes);
    }   
	// print_r($current_user->roles);
	// die();
}
 
function custom_dashboard_help() {
echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none;}</style>';
echo '<p>Welcome to Affiliate Manager Section! </p>';
}

function custom_dashboard_help_cm() {
	echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none;}</style>';
	echo '<p>Welcome to Affiliate Manager Section! </p>';
}

function custom_dashboard_help_ca() {
	echo '<style>.update-nag, .toplevel_page_newaffiliate{display:none;}</style>';
	echo '<p>Welcome to Affiliate Manager Section! </p>';
}




add_action( 'admin_footer', 'acme_edit_post', 999 );
function acme_edit_post()
{

	 $current_user   = wp_get_current_user();
     $role_name      = $current_user->roles[0];
	 if ( 'employer' === $role_name ) { 
	 remove_meta_box( 'commentstatusdiv', 'jobpost', 'normal' );
	 remove_meta_box( 'commentsdiv', 'jobpost', 'normal' );
	 //echo "<style>#themify-meta-boxes{display:none !important;}</style>";
	?>
	
	<script>
	function myFunction() {
		var x = document.getElementById("themify-meta-boxes");
		var y = document.getElementById("jobpost_metas");
		var z = document.getElementById("simple-job-board-post_options");
		if(x){
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
		}
		if(y){
			if (y.style.display === "none") {
			y.style.display = "block";
		} else {
			y.style.display = "none";
		}
		}
		if(z){
			if (z.style.display === "none") {
			z.style.display = "block";
		} else {
			z.style.display = "none";
		}
		}
	}
	myFunction();
	</script>
	
<?php } }

function set_default_admin_color($user_id) {
	$args = array(
		'ID' => $user_id,
		'admin_color' => 'admin_color_schemer_1'
	);
	wp_update_user( $args );
}
add_action('user_register', 'set_default_admin_color');


add_filter( 'get_user_option_admin_color', 'wprole_set_admin_color' );
function wprole_set_admin_color()
{
    $current_user = wp_get_current_user();

	$role_name      = $current_user->roles[0];
	$role_name1      = $current_user->roles[0];
 
    if ( 'chat_manager' === $role_name || 'chat_manager' === $role_name1 || 'chat_agent' === $role_name || 'chat_agent' === $role_name1 ) {
        // Remove the Admin Color Scheme picker
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

        // Set the Admin Color Scheme you want for this role
        return 'ectoplasm';
    }
}

function howdy_message($translated_text, $text, $domain) {
	$new_message = str_replace('Howdy', 'Welcome', $text);
	return $new_message;
	}
add_filter('gettext', 'howdy_message', 10, 3);


?>

