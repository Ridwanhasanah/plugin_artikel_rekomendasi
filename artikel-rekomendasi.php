<?php
/*
  Plugin Name: Artikel Rekomendasi
  Plugin URI: https://www.facebook.com/ridwan.hasanah3
  Description: Artikel yang di rekomendnasikan
  Version: 1.0
  Author: Ridwan Hasanah
  Author URI: https://www.facebook.com/ridwan.hasanah3
*/


add_shortcode('artikel-rekomendasi', 'rh_artikel_rekomendasi' );

function rh_artikel_rekomendasi(){
	

	$tags = wp_get_post_tags(get_the_ID());
	$related_posts = array();
	if ($tags) {
		$tag_ids = array();
		foreach ($tags as $tag) {
			$tag_ids[] = $tag->term_id;
		}

		$args = array(
			'tag__in' => $tag_ids,
			'post__not_in' => array(get_the_ID()),
			'post_per_page' => 5,
			'ignore_sticky_posts' => 1
			);
		$my_query = new wp_query($args);
		while($my_query->have_posts()){
			$my_query->the_post();
			$related_posts[] = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
		}
	}
	wp_reset_query();
	if (!empty($related_posts)) {
		return '<p>'.implode('<br>',$related_posts).'</p>';
	}
}

add_action('admin_head','rh_artikel_rekomendasi_add_button' );
function rh_artikel_rekomendasi_add_button(){
	global $typenow;
	
	if (!current_user_can('edit_posts' )){
		return;
	}
	if ($typenow != 'post') {
		return;
	}
	if (get_user_option('rich_editing' ) == 'true') {
		add_filter("mce_external_plugins", "rh_artikel_add_tinymce_plugin" );
		add_filter("mce_buttons","rh_artikel_register_button" );
	}
}

function rh_artikel_add_tinymce_plugin($plugin_array){

	$plugin_array['artikel_rekomendasi'] = plugins_url('/artikel-rekomendasi.js',__FILE__ );
	return $plugin_array;

	function rh_artikel_register_button(){
		array_push($buttons,"artikel_rekomendasi");

		return $buttons;
	}
}
?>

