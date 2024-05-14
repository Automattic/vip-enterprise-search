<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/internal/mock-header.php';
require_once __DIR__ . '/internal/class-constants-mocker.php';

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

if ( '1' === getenv( 'VIP_JETPACK_SKIP_LOAD' ) ) {
	define( 'VIP_JETPACK_SKIP_LOAD', true );
}

require_once $_tests_dir . '/includes/functions.php';

// Constant configs
// Ideally we'd have a way to mock these
define( 'FILES_CLIENT_SITE_ID', 123 );
define( 'WPCOM_VIP_MAIL_TRACKING_KEY', 'key' );
define( 'WPCOM_VIP_DISABLE_REMOTE_REQUEST_ERROR_REPORTING', true );

function _manually_load_plugin() {
	require_once __DIR__ . '/../../src/search.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require_once $_tests_dir . '/includes/bootstrap.php';

if ( isset( $GLOBALS['wp_version'] ) ) {
	echo PHP_EOL, 'WordPress version: ' . esc_html( $GLOBALS['wp_version'] ), PHP_EOL;
}
