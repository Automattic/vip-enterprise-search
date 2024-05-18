<?php

// phpcs:disable Universal.Namespaces.DisallowCurlyBraceSyntax.Forbidden, Universal.Namespaces.OneDeclarationPerFile.MultipleFound

namespace Automattic\Test {
	$status_code = false;
	$headers     = [];

	function header_remove( ?string $name = null ): void {
		global $headers, $status_code;
		if ( null === $name ) {
			$headers     = [];
			$status_code = false;
		} else {
			foreach ( $headers as $index => $header ) {
				$parts = explode( ':', $header, 2 );
				$hname = strtolower( trim( $parts[0] ) );
				if ( ! strcasecmp( $hname, $name ) ) {
					unset( $headers[ $index ] );
				}
			}
		}
	}

	function headers_list(): array {
		global $headers;
		return array_values( $headers );
	}

	function headers_sent(): bool {
		return false;
	}

	function header( string $header, bool $replace = true ) {
		global $headers;

		if ( $replace ) {
			$parts = explode( ':', $header, 2 );
			$name  = trim( $parts[0] );
			namespace\header_remove( $name );
		}

		$headers[] = $header;
	}

	function http_response_code( $code = 0 ) {
		global $status_code;
		if ( ! $code ) {
			return $status_code;
		}

		$previous    = $status_code;
		$status_code = $code;
		return $previous;
	}
}

namespace Automattic\VIP\Search {
	function header_remove( ?string $name = null ): void {
		\Automattic\Test\header_remove( $name );
	}

	function headers_list(): array {
		return \Automattic\Test\headers_list();
	}

	function headers_sent(): bool {
		return \Automattic\Test\headers_sent();
	}

	function header( string $header, bool $replace = true ) {
		\Automattic\Test\header( $header, $replace );
	}
}
