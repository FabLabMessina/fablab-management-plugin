<?php

function disable_user_field( $field ) {
    if ( !current_user_can('list_users') ) {
        $field['disabled'] = true;
    }
    return $field;
}

function deny_user_update( $value, $post_id, $field  ) {
    if ( !current_user_can('list_users') ) {
        return get_field( $field['name'], $post_id );
    } else {
        return $value;
    }
}

function edit_columns_users( $column_headers ) {
    unset( $column_headers ['name'] );
    unset( $column_headers ['role'] );
    unset( $column_headers ['posts'] );

    $column_headers ['numero_tessera'] = 'Numero tessera';
    $column_headers ['scadenza_tessera'] = 'Scadenza tessera';

    return $column_headers;
}

function add_extra_columns_users( $custom_column, $column_name, $user_id ) {
    if ( $column_name == 'numero_tessera' ) {
        return get_field( 'numero_tessera', 'user_' . $user_id );
    }

    if ( $column_name == 'scadenza_tessera' ) {
        $expire_date = get_field( 'scadenza_tessera', 'user_' . $user_id );

        if ( $expire_date != '' ) {
            $color = $expire_date > date('Ymd') ? 'green' : 'red';
            $formatted_date = date( 'd-m-Y', strtotime( $expire_date ) );
            return "<span style='color:$color'>$formatted_date</span>";
        } else {
            return '&mdash;';
        }
    }
}

function manage_extra_columns_users( $query ) {
    if ( 'Numero tessera' == $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'meta_key', 'numero_tessera' );
    }

    if ( 'Scadenza tessera' == $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'meta_key', 'scadenza_tessera' );
    }

    preg_match('/^\*([0-9]+)\*$/', $query->get('search'), $matches);

    if( $matches ) {
        $meta_query = array(
            array(
                'key'     => 'numero_tessera',
                'value'   => $matches[1],
                'compare' => '='
            )
        );

        $query->set( 'search', '' );
        $query->set( 'meta_query', $meta_query );

    }
}


class users {

    static function register_acf_info() {
        if( function_exists('acf_add_local_field_group') ):
            global $wpdb;

            $next_id = '';
            if ( is_admin() ) {
                $query = "SELECT MAX( CAST(meta_value AS UNSIGNED) ) FROM $wpdb->users, $wpdb->usermeta WHERE ID=user_id AND meta_key='numero_tessera'";
                $next_id = intval( $wpdb->get_var($query) ) + 1;
            }

            acf_add_local_field_group(array(
	            'key' => 'group_5aabd4fd85467',
                'title' => 'Info utente 🔒',
	            'fields' => array(
		            array(
			            'key' => 'field_5aabd5251d4e2',
			            'label' => 'Telefono',
			            'name' => 'telefono',
			            'type' => 'text',
			            'instructions' => '',
			            'required' => 0,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => '',
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'maxlength' => '',
		            ),
		            array(
			            'key' => 'field_5aabd5081d4e1',
			            'label' => 'Residenza',
			            'name' => 'residenza',
			            'type' => 'text',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => '',
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'maxlength' => '',
		            ),
		            array(
			            'key' => 'field_5aabd53b1d4e3',
			            'label' => 'Nato a',
			            'name' => 'nato_a',
			            'type' => 'text',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => '',
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'maxlength' => '',
		            ),
		            array(
			            'key' => 'field_5aabd5571d4e4',
			            'label' => 'Nato il',
			            'name' => 'nato_il',
			            'type' => 'date_picker',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'display_format' => 'd/m/Y',
			            'return_format' => 'Ymd',
			            'first_day' => 1,
		            ),
		            array(
			            'key' => 'field_5aabd5aa1d4e5',
			            'label' => 'Codice fiscale',
			            'name' => 'codice_fiscale',
			            'type' => 'text',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => '',
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'maxlength' => 16,
		            ),
		            array(
			            'key' => 'field_5aabd5ed1d4e6',
			            'label' => 'Data registrazione',
			            'name' => 'data_registrazione',
			            'type' => 'date_picker',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'display_format' => 'd/m/Y',
			            'return_format' => 'Ymd',
			            'first_day' => 1,
		            ),
		            array(
			            'key' => 'field_5aabd6141d4e7',
			            'label' => 'Numero tessera',
			            'name' => 'numero_tessera',
			            'type' => 'number',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => $next_id,
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'min' => '',
			            'max' => '',
			            'step' => '',
		            ),
		            array(
			            'key' => 'field_5aabd6671d4e8',
			            'label' => 'Scadenza tessera',
			            'name' => 'scadenza_tessera',
			            'type' => 'date_picker',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'display_format' => 'd/m/Y',
			            'return_format' => 'Ymd',
			            'first_day' => 1,
		            ),
		            array(
			            'key' => 'field_5aabd6c31d4e9',
			            'label' => 'Crediti',
			            'name' => 'crediti',
			            'type' => 'number',
			            'instructions' => '',
			            'required' => 1,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'default_value' => 0,
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'min' => '',
			            'max' => '',
			            'step' => '',
		            ),
		            array(
			            'key' => 'field_5aabd6db1d4ea',
			            'label' => 'Interessi',
			            'name' => 'interessi',
			            'type' => 'taxonomy',
			            'instructions' => '',
			            'required' => 0,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'taxonomy' => 'post_tag',
			            'field_type' => 'multi_select',
			            'allow_null' => 1,
			            'add_term' => 0,
			            'save_terms' => 0,
			            'load_terms' => 0,
			            'return_format' => 'id',
			            'multiple' => 0,
		            ),
	            ),
	            'location' => array(
		            array(
			            array(
				            'param' => 'user_form',
				            'operator' => '==',
				            'value' => 'all',
			            ),
		            ),
	            ),
	            'menu_order' => 0,
	            'position' => 'normal',
	            'style' => 'default',
	            'label_placement' => 'top',
	            'instruction_placement' => 'label',
	            'hide_on_screen' => '',
	            'active' => 1,
	            'description' => '',
            ));
        endif;
    }

    static function lock_acf_info() {
        add_filter( 'acf/prepare_field/name=residenza', 'disable_user_field');
        add_filter('acf/update_value/name=residenza', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=telefono', 'disable_user_field');
        add_filter('acf/update_value/name=telefono', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=nato_a', 'disable_user_field');
        add_filter('acf/update_value/name=nato_a', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=nato_il', 'disable_user_field');
        add_filter('acf/update_value/name=nato_il', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=codice_fiscale', 'disable_user_field');
        add_filter('acf/update_value/name=codice_fiscale', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=data_registrazione', 'disable_user_field');
        add_filter('acf/update_value/name=data_registrazione', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=numero_tessera', 'disable_user_field');
        add_filter('acf/update_value/name=numero_tessera', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=scadenza_tessera', 'disable_user_field');
        add_filter('acf/update_value/name=scadenza_tessera', 'deny_user_update', 10, 3);

        add_filter( 'acf/prepare_field/name=crediti', 'disable_user_field');
        add_filter('acf/update_value/name=crediti', 'deny_user_update', 10, 3);
    }

    static function register_acf_management() {
        if( function_exists('acf_add_local_field_group') ):
            acf_add_local_field_group(array(
	            'key' => 'group_5aabddf8867e1',
	            'title' => 'Amministrazione utente',
	            'fields' => array(
		            array(
			            'key' => 'field_5aabddfee2ad7',
			            'label' => 'Tipologia socio',
			            'name' => 'tipologia_socio',
			            'type' => 'button_group',
			            'instructions' => '',
			            'required' => 0,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'choices' => array(
				            'ordinario' => 'Ordinario',
				            'effettivo' => 'Effettivo',
				            'sostenitore' => 'Sostenitore',
			            ),
			            'allow_null' => 0,
			            'default_value' => 'ordinario',
			            'layout' => 'horizontal',
			            'return_format' => 'value',
		            ),
		            array(
			            'key' => 'field_5aabde69e2ad8',
			            'label' => 'Badges',
			            'name' => 'badges',
			            'type' => 'checkbox',
			            'instructions' => '',
			            'required' => 0,
			            'conditional_logic' => 0,
			            'wrapper' => array(
				            'width' => '',
				            'class' => '',
				            'id' => '',
			            ),
			            'choices' => array(
				            'lasercutter' => 'Laser Cutter',
				            'fdm3dprinter' => 'FDM 3D Printer',
				            'cncengraver' => 'CNC Engraver',
			            ),
			            'allow_custom' => 0,
			            'save_custom' => 0,
			            'default_value' => array(
			            ),
			            'layout' => 'horizontal',
			            'toggle' => 0,
			            'return_format' => 'value',
		            ),
	            ),
	            'location' => array(
		            array(
			            array(
				            'param' => 'user_form',
				            'operator' => '==',
				            'value' => 'all',
			            ),
			            array(
				            'param' => 'current_user_role',
				            'operator' => '==',
				            'value' => 'administrator',
			            ),
		            ),
	            ),
	            'menu_order' => 0,
	            'position' => 'normal',
	            'style' => 'default',
	            'label_placement' => 'top',
	            'instruction_placement' => 'label',
	            'hide_on_screen' => '',
	            'active' => 1,
	            'description' => '',
            ));
        endif;
    }

    static function edit_columns() {
        add_action('pre_get_users', 'manage_extra_columns_users');
        add_action('manage_users_columns','edit_columns_users');
        add_action('manage_users_sortable_columns','edit_columns_users');
        add_action('manage_users_custom_column','add_extra_columns_users', 10, 3);
    }
}
