<?php

namespace Automattic\VIP\Search;

class Alerts {
	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	protected static function clear_instance() {
		self::$instance = null;
	}

	public function send_to_chat( $channel_or_user, $message, $level = 0, $kind = '', $interval = 1 ) {
		if ( class_exists( \Automattic\VIP\Utils\Alerts::class ) ) {
			return \Automattic\VIP\Utils\Alerts::chat( $channel_or_user, $message, $level, $kind, $interval );
		}

		return false;
	}

	public static function chat( $channel_or_user, $message, $level = 0, $kind = '', $interval = 1 ) {
		return self::instance()->send_to_chat( $channel_or_user, $message, $level, $kind, $interval );
	}
}
