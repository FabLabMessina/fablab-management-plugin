<?php
/*
Plugin Name: FabLab Management
Description: Manage all the aspect of your FabLab: events, projects and users. Requires Advanced Custom Field plugin.
Version: 0.9
Author: Francesco Franchina
*/

//define( 'ACF_LITE', true );
define('ACF_EARLY_ACCESS', '5');

require_once plugin_dir_path(__FILE__) . '/lib/events.php';
require_once plugin_dir_path(__FILE__) . '/lib/projects.php';
require_once plugin_dir_path(__FILE__) . '/lib/users.php';

events::register_post_type();
events::register_acf_info();
events::register_acf_partecipants();

projects::register_post_type();
projects::register_acf_info();

users::register_acf_info();
users::lock_acf_info();
users::register_acf_management();
users::edit_columns();
