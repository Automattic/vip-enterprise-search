<?php
namespace Automattic\VIP\Search;

use Automattic\Test\Constant_Mocker;
use WP_Query;
use WP_UnitTestCase;

class CacheTest extends WP_UnitTestCase {
	private $apc_filters = [
		'posts_request',
		'posts_results',
		'post_limits_request',
		'found_posts_query',
		'found_posts',
	];

	/** @var Search */
	private $es;

	public function setUp(): void {
		parent::setUp();

		Constant_Mocker::clear();
		Constant_Mocker::define( 'VIP_ELASTICSEARCH_ENDPOINTS', array( 'https://elasticsearch:9200' ) );

		$this->es = new Search();
		$this->es->init();

		\ElasticPress\register_indexable_posts();

		add_filter( 'ep_skip_query_integration', '__return_false', 100 );
	}

	public function tearDown(): void {
		Constant_Mocker::clear();
		parent::tearDown();
	}

	public function test_apc_compat_pre_get_posts_wired() {
		$this->assertIsInt( has_action( 'pre_get_posts', array( $this->es->cache, 'disable_apc_for_ep_enabled_requests' ) ) );
	}

	public function test_disable_enable_apc() {
		if ( ! class_exists( 'Advanced_Post_Cache' ) ) {
			$this->markTestSkipped( 'Advanced Post Cache is not available' );
		}

		// All of APC's filters should be unhooked for EP queries
		new WP_Query( [ // NOSONAR
			's'            => 'test',
			'ep_integrate' => true,
		] );

		$filters = array_filter( $this->apc_filters, function ( $filter ) {
			return false !== has_filter( $filter, [ $GLOBALS['advanced_post_cache_object'], $filter ] );
		} );

		$this->assertEmpty( $filters, 'Failed to remove APC filters' );

		// All of APC's filters should be re-enabled for any non-EP query
		new WP_Query( [ 'posts_per_page' => 10 ] ); // NOSONAR

		$filters = array_filter( $this->apc_filters, function ( $filter ) {
			return false !== has_filter( $filter, [ $GLOBALS['advanced_post_cache_object'], $filter ] );
		} );

		$this->assertEquals( count( $this->apc_filters ), count( $filters ), 'Failed to re-attach APC filters' );
	}
}
