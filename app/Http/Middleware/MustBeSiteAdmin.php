<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustBeSiteAdmin
{
    /**
     * Allow overall SiteAdmin / SiteSubAdmin; send other roles to their dashboards.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ($user->isSiteAdmin() || $user->isSiteSubAdmin())) {
            return $next($request);
        }

        if ($user && $user->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        if ($user && $user->isTeacher()) {
            return redirect('/teacher/dashboard');
        }

        if ($user && $user->isStudent()) {
            return redirect('/student/dashboard');
        }

        if ($user && $user->isLibrarian()) {
            return redirect('/library/dashboard');
        }

        abort(404);
    }
}
