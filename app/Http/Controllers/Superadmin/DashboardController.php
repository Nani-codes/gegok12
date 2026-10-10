<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $schools = School::query()
            ->orderBy('name')
            ->get(['id', 'name', 'status', 'email', 'created_at']);

        $schoolAdminCount = User::query()
            ->where('usergroup_id', User::SCHOOLADMIN_USERGROUP_ID)
            ->count();

        return view('superadmin.dashboard', [
            'schools' => $schools,
            'schoolAdminCount' => $schoolAdminCount,
        ]);
    }
}
