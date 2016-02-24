<?php
/**
 * @package Multilingual Modifications
 * @version 0.1
 */
/*
Plugin Name: Multilingual Modifications
Description: Experiments on Babble. This functionality lets one navigation menu work in multiple languages.
Author: Klaus Harris
Version: 0.1
Author URI: http://www.klausharris.de
*/

/**
 * This could come from a settings form. The value here is the name of a WordPress menu
 */
define( 'MULTILANG_MODS_MENU_NAME', 'Multilang' );

/**
 * Menu override function, this has an effect if the menu urls are something like this:
 * 
 * /en/blog
 * /de/blog
 *
 * returning only menu items in the current language, the key is the language prefix. An
 * alternative would be to have different menus, one for each language and then choose one at a 
 * theme level.
 *
 * @param $items
 * @param $args
 * @return array|void
 */
function multilang_mods_change_menu( $items, $args ) {

	if( !function_exists( 'bbl_get_current_lang_code' ) ) {
		return $items;
	}

	if( empty( $args->menu->name ) || $args->menu->name != MULTILANG_MODS_MENU_NAME ) {
		return;
	}

	$out = array();
	$urlLangPrefix = sprintf( '/%s/', substr( bbl_get_current_lang_code(), 0, 2 ) );

	foreach( $items as & $item ) {
		if( strpos( $item->url, $urlLangPrefix ) !== false ){
			$out[] = $item;
		}
	}	
	return $out;

} add_filter( 'wp_nav_menu_objects', 'multilang_mods_change_menu', '', 2 );