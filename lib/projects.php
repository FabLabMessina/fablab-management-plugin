<?php

function cptui_register_my_cpts_progetto() {
	$labels = array(
		"name" => 'Progetti',
		"singular_name" => 'Progetto',
		"menu_name" => 'Progetti',
		"all_items" => 'Tutti i Progetti',
		"add_new" => 'Aggiungi nuovo',
		"add_new_item" => 'Aggiungi nuovo Progetto',
		"edit_item" => 'Modifica Progetto',
		"new_item" => 'Nuovo Progetto',
		"view_item" => 'Visualizza Progetto',
		"search_items" => 'Cerca Progetto',
		"not_found" => 'Nessun Progetto trovato',
		);

	$args = array(
		"label" => 'Progetti',
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
		"rewrite" => array( "slug" => "progetto", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 7,"menu_icon" => "dashicons-clipboard",		
		"supports" => array( "title", "editor", "thumbnail" ),		
		"taxonomies" => array( "category", "post_tag" ),
	);
	register_post_type( "progetto", $args );
}


class projects {

    static function register_post_type() {
        add_action( 'init', 'cptui_register_my_cpts_progetto' );
    }

    static function register_acf_info() {
        if( function_exists('acf_add_local_field_group') ):
            acf_add_local_field_group(array(
	            'key' => 'group_5aabeb4677f29',
	            'title' => 'Autori',
	            'fields' => array(
		            array(
			            'key' => 'field_5aabebb955c41',
			            'label' => 'Autori',
			            'name' => 'autori',
			            'type' => 'user',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'role' => '',
			            'allow_null' => 0,
			            'multiple' => 1,
			            'return_format' => 'array',
		            ),
	            ),
	            'location' => array(
		            array(
			            array(
				            'param' => 'post_type',
				            'operator' => '==',
				            'value' => 'progetto',
			            ),
		            ),
	            ),
	            'menu_order' => 0,
	            'position' => 'side',
	            'style' => 'default',
	            'label_placement' => 'top',
	            'instruction_placement' => 'label',
	            'hide_on_screen' => '',
	            'active' => 1,
	            'description' => '',
            ));
        endif;
    }
}
