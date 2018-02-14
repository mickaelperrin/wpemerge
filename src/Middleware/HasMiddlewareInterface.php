<?php

namespace WPEmerge\Middleware;

use Closure;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for HasMiddlewareTrait
 */
interface HasMiddlewareInterface {
	/**
	 * Get registered middleware.
	 *
	 * @return array
	 */
	public function getMiddleware();

	/**
	 * Add middleware.
	 * Accepts: a class name, an instance of a class, a Closure or an array of any of the previous.
	 *
	 * @param  string|\Closure|\WPEmerge\Middleware\MiddlewareInterface|array $middleware
	 * @return object                                                         $this
	 */
	public function addMiddleware( $middleware );

	/**
	 * Alias for addMiddleware.
	 *
	 * @param  string|\Closure|\WPEmerge\Middleware\MiddlewareInterface|array $middleware
	 * @return object                                                         $this
	 */
	public function add( $middleware );

	/**
	 * Remove middleware.
	 *
	 * @param  string|\Closure|\WPEmerge\Middleware\MiddlewareInterface|array $middleware
	 * @return object                                                         $this
	 */
	public function removeMiddleware( $middleware );

	/**
	 * Alias for removeMiddleware.
	 *
	 * @param  string|\Closure|\WPEmerge\Middleware\MiddlewareInterface|array $middleware
	 * @return object                                                         $this
	 */
	public function remove( $middleware );

	/**
	 * Execute an array of middleware recursively (last in, first out).
	 *
	 * @param  array                      $middleware
	 * @param  \WPEmerge\Requests\Request $request
	 * @param  Closure                    $next
	 * @return ResponseInterface
	 */
	public function executeMiddleware( $middleware, $request, Closure $next );
}
