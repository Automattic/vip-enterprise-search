<?php

namespace Automattic\VIP\Search;

class Logger {
	/**
	 * Adds a log entry.
	 *
	 * @param string $level   One of:
	 *     - 'emergency': System is unusable.
	 *     - 'alert'    : Action must be taken immediately.
	 *     - 'critical' : Critical conditions.
	 *     - 'error'    : Error conditions.
	 *     - 'warning'  : Warning conditions.
	 *     - 'notice'   : Normal but significant condition.
	 *     - 'info'     : Informational messages.
	 *     - 'debug'    : Debug-level messages.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My log message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function log( string $level, string $feature, string $message, array $context = [] ): void {
		static::log2logstash( [
			'severity' => $level,
			'feature'  => $feature,
			'message'  => $message,
			'extra'    => $context,
		] );
	}

	/**
	 * Adds an emergency level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My emergency message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function emergency( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds an alert level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My alert message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function alert( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds a critical level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My critical message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function critical( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds an error level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My error message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function error( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds a warning level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My warning message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function warning( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds a notice level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My notice message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function notice( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds a info level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My info message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function info( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	/**
	 * Adds a debug level message.
	 *
	 * @param string $feature Log feature; e.g., `my_feature_slug`.
	 * @param string $message Log message; e.g., `My debug message.`.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function debug( string $feature, string $message, array $context = [] ): void {
		$this->log( __FUNCTION__, $feature, $message, $context );
	}

	public static function log2logstash( array $data ): void {
		if ( class_exists( \Automattic\VIP\Logstash\Logger::class ) ) {
			\Automattic\VIP\Logstash\Logger::log2logstash( $data );
		}
	}

	public static function process_entries_on_shutdown(): void {
		if ( class_exists( \Automattic\VIP\Logstash\Logger::class ) ) {
			\Automattic\VIP\Logstash\Logger::process_entries_on_shutdown();
		}
	}
}
