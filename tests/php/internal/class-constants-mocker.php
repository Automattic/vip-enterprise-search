<?php

// phpcs:disable Universal.Namespaces.DisallowCurlyBraceSyntax.Forbidden
// phpcs:disable Universal.Namespaces.OneDeclarationPerFile.MultipleFound
// phpcs:disable Universal.Files.SeparateFunctionsFromOO.Mixed

namespace Automattic\Test {

	use Exception;
	use InvalidArgumentException;

	abstract class Constant_Mocker {
		private static $constants = [
			'ABSPATH' => '/tmp/wordpress',
		];

		public static function clear(): void {
			self::$constants = [
				'ABSPATH' => '/tmp/wordpress',
			];
		}

		public static function define( string $constant, $value ): void {
			$constant = ltrim( $constant, '\\' );
			if ( isset( self::$constants[ $constant ] ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- CLI
				throw new InvalidArgumentException( sprintf( "Constant \"%s\" is already defined. Stacktrace:\n%s", $constant, self::$constants[ $constant ][1] ) );
			}

			$e = new Exception();

			self::$constants[ $constant ] = [ $value, $e->getTraceAsString() ];
		}

		public static function defined( string $constant ): bool {
			$constant = ltrim( $constant, '\\' );
			return isset( self::$constants[ $constant ] );
		}

		public static function constant( string $constant ) {
			$constant = ltrim( $constant, '\\' );
			if ( ! isset( self::$constants[ $constant ] ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- CLI
				throw new InvalidArgumentException( sprintf( 'Constant "%s" is not defined', $constant ) );
			}

			return self::$constants[ $constant ][0];
		}

		public static function undefine( string $constant ): void {
			$constant = ltrim( $constant, '\\' );
			unset( self::$constants[ $constant ] );
		}
	}
}

namespace Automattic\VIP\Search {
	use Automattic\Test\Constant_Mocker;

	function defined( $constant ) {
		return Constant_Mocker::defined( $constant );
	}

	function constant( $constant ) {
		return Constant_Mocker::constant( $constant );
	}

	function define( $constant, $value ) {
		Constant_Mocker::define( $constant, $value );
	}
}

namespace Automattic\VIP\Search\Queue {
	use Automattic\Test\Constant_Mocker;

	function defined( $constant ) {
		return Constant_Mocker::defined( $constant );
	}

	function constant( $constant ) {
		return Constant_Mocker::constant( $constant );
	}

	function define( $constant, $value ) {
		Constant_Mocker::define( $constant, $value );
	}
}
