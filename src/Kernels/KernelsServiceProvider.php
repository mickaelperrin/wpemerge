<?php
/**
 * @package   WPEmerge
 * @author    Atanas Angelov <atanas.angelov.dev@gmail.com>
 * @copyright 2018 Atanas Angelov
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://wpemerge.com/
 */

namespace WPEmerge\Kernels;

use WPEmerge\ServiceProviders\ExtendsConfigTrait;
use WPEmerge\ServiceProviders\ServiceProviderInterface;

/**
 * Provide old input dependencies.
 *
 * @codeCoverageIgnore
 */
class KernelsServiceProvider implements ServiceProviderInterface {
	use ExtendsConfigTrait;

	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$this->extendConfig( $container, 'middleware', [
			'flash' => \WPEmerge\Flash\FlashMiddleware::class,
			'oldinput' => \WPEmerge\Input\OldInputMiddleware::class,
		] );
		$this->extendConfig( $container, 'middleware_groups', [
			'global' => [
				'flash',
				'oldinput',
			],

			'web' => [],
			'ajax' => [],
			'admin' => [],
		] );
		$this->extendConfig( $container, 'middleware_priority', [] );

		$container[ WPEMERGE_WORDPRESS_HTTP_KERNEL_KEY ] = function ( $c ) {
			$kernel = new HttpKernel(
				$c[ WPEMERGE_APPLICATION_KEY ],
				$c[ WPEMERGE_REQUEST_KEY ],
				$c[ WPEMERGE_ROUTING_ROUTER_KEY ],
				$c[ WPEMERGE_EXCEPTIONS_ERROR_HANDLER_KEY ]
			);

			$kernel->setMiddleware( $c[ WPEMERGE_CONFIG_KEY ]['middleware'] );
			$kernel->setMiddlewareGroups( $c[ WPEMERGE_CONFIG_KEY ]['middleware_groups'] );
			$kernel->setMiddlewarePriority( $c[ WPEMERGE_CONFIG_KEY ]['middleware_priority'] );

			return $kernel;
		};
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}