<?php

// CUSTOM POST

add_action( 'init', 'cptui_register_my_cpts_evento' );
function cptui_register_my_cpts_evento() {
	$labels = array(
		"name" => 'Eventi',
		"singular_name" => 'Evento',
		"menu_name" => 'Eventi',
		"all_items" => 'Tutti gli Eventi',
		"add_new" => 'Aggiungi nuovo',
		"add_new_item" => 'Aggiungi nuovo Evento',
		"edit_item" => 'Modifica Evento',
		"new_item" => 'Nuovo Evento',
		"view_item" => 'Visualizza Evento',
		"search_items" => 'Cerca Evento',
		"not_found" => 'Nessun Evento trovato',
		);

	$args = array(
		"label" => 'Eventi',
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "evento", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 6,"menu_icon" => "dashicons-calendar-alt",		
		"supports" => array( "title", "editor", "thumbnail" ),		
		"taxonomies" => array( "category" ),		
	);
	register_post_type( "evento", $args );
}
