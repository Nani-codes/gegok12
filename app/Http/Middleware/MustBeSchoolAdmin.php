<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustBeSchoolAdmin
{
    /**
     * Allow school admins; send SiteAdmin to superadmin (not abort 404).
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if ($user && ($user->isSiteAdmin() || $user->isSiteSubAdmin())) {
            return redirect('/superadmin/dashboard');
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

        if ($user && $user->isAlumni()) {
            return redirect('/alumni/dashboard');
        }

        if ($user && $user->isReceptionist()) {
            return redirect('/receptionist/dashboard');
        }

        if ($user && $user->isAccountant()) {
            return redirect('/accountant/dashboard');
        }

        if ($user && $user->isStockKeeper()) {
            return redirect('/stock/dashboard');
        }

        abort(404);
    }
}
