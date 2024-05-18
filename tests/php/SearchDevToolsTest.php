<?php

namespace Automattic\VIP\Search;

use WP_Error;
use WP_REST_Request;
use WP_UnitTestCase;

use function Automattic\VIP\Search\Dev_Tools\rest_endpoint_url_validate_callback;

class SearchDevToolsTest extends WP_UnitTestCase {
	public function setUp(): void {
		require_once __DIR__ . '/../../src/search-dev-tools/search-dev-tools.php';
		do_action( 'rest_api_init' );
	}

	public function data_provider_endpoint_urls() {
		return [
			[
				'input'    => 'http://vip-search:9200/vip-123-post-1/_search',
				'expected' => true,
			],
			[
				'input'    => 'http://vip-search:9200/vip-123-post-1,vip-123-post-post-2-v1/_search',
				'expected' => true,
			],
			[
				'input'    => 'http://vip-search:9200/vip-123-post-v1,vip-3456-post-2-v1/_search',
				'expected' => new WP_Error( 'rest_invalid_param', sprintf( '%s is not a valid allowed URL', 'url' ) ),
			],
			[
				'input'    => 'http://vip-search:9200/vip-2345-post-v1/_search',
				'expected' => new WP_Error( 'rest_invalid_param', sprintf( '%s is not a valid allowed URL', 'url' ) ),
			],
			[
				'input'    => 'http://vip-search:9200/restricted/_endpoint',
				'expected' => new WP_Error( 'rest_invalid_param', sprintf( '%s is not a valid allowed URL', 'url' ) ),
			],
			[
				'input'    => 'notavalidurl',
				'expected' => new WP_Error( 'rest_invalid_param', sprintf( '%s is not a valid allowed URL', 'url' ) ),
			],
		];
	}

	/**
	 * @dataProvider data_provider_endpoint_urls
	 */
	public function test__url_validation( $input, $expected ) {
		$val = rest_endpoint_url_validate_callback( $input, new WP_REST_Request( 'POST' ), 'url' );
		static::assertEquals( $val, $expected, 'URL validation failed' );
	}
}
