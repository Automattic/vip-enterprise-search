<?php
/**
 * Plugin Name: VIP Search
 * Description: Power your site search and other queries with Elasticsearch
 * Version:     1.0
 * Author:      Automattic VIP
 * Author URI:  https://wpvip.com
 * License:     GPLv2 or later
 * Text Domain: vip-search
 * Domain Path: /lang/
 *
 * @package Automattic\VIP\Search
 */

namespace Automattic\VIP\Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If VIP_ELASTICSEARCH_DISABLED is explicitly set to `true`, then don't load the plugin
if ( defined( 'VIP_ELASTICSEARCH_DISABLED' ) && true === constant( 'VIP_ELASTICSEARCH_DISABLED' ) ) {
	return;
}

require_once __DIR__ . '/includes/classes/class-alerts.php';
require_once __DIR__ . '/includes/classes/class-logger.php';
require_once __DIR__ . '/includes/functions/utils.php';
require_once __DIR__ . '/includes/classes/class-search.php';

if ( Search::are_es_constants_defined() && ! wp_installing() ) {
	$search_plugin = Search::instance();

	require_once __DIR__ . '/search-dev-tools/search-dev-tools.php';

	// If VIP Search query integration is enabled, disable Jetpack Search
	if ( ! $search_plugin::ep_skip_query_integration( false ) ) {
		add_filter( 'jetpack_active_modules', array( $search_plugin, 'filter__jetpack_active_modules' ), PHP_INT_MAX );
		add_filter( 'jetpack_widgets_to_include', array( $search_plugin, 'filter__jetpack_widgets_to_include' ), PHP_INT_MAX );
		add_filter( 'jetpack_search_should_handle_query', '__return_false', PHP_INT_MAX );
	}

	do_action( 'vip_search_loaded' );
}
