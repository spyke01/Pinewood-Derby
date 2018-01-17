<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClearanceMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {        
        if (Auth::user()->hasPermissionTo('Administer roles & permissions')) {
            return $next($request);
        }

//	    // This is accessible by all
//	    if ( $request->is('*leader-board*') ) {
//		    return $next($request);
//	    }

        if ($request->is('posts/create')) {
            if (!Auth::user()->hasPermissionTo('Create Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
            
        if ($request->is('posts/*/edit')) {
            if (!Auth::user()->hasPermissionTo('Edit Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->isMethod('Delete')) {
            if (!Auth::user()->hasPermissionTo('Delete Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

	    if ( $request->is('contestants*') ) {
		    if (!Auth::user()->hasPermissionTo('Manage Contestants')) {
			    abort('401');
		    } else {
			    return $next($request);
		    }
	    }

	    if ( $request->is('heats*') ) {
		    if (!Auth::user()->hasPermissionTo('Manage Heats')) {
			    abort('401');
		    } else {
			    return $next($request);
		    }
	    }

	    if ( $request->is('runs*') ) {
		    if (!Auth::user()->hasPermissionTo('Manage Runs')) {
			    abort('401');
		    } else {
			    return $next($request);
		    }
	    }

	    if ( $request->is('dens*') || $request->is('groups*') || $request->is('scores-for-positions*') ) {
		    if (!Auth::user()->hasPermissionTo('Change Configuration')) {
			    abort('401');
		    } else {
			    return $next($request);
		    }
	    }

        return $next($request);
    }
}