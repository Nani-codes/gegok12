<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site Admin Dashboard — GegoK12</title>
    <style>
        :root { color-scheme: light; }
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, sans-serif; margin: 0; background: #f4f6f8; color: #111827; }
        header { background: #111827; color: #fff; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; opacity: .85; }
        main { max-width: 960px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: #fff; border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 1rem; }
        h1 { margin: 0 0 .25rem; font-size: 1.5rem; }
        p.muted { color: #6b7280; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: .75rem .5rem; border-bottom: 1px solid #e5e7eb; font-size: .95rem; }
        th { color: #6b7280; font-weight: 600; }
        .badge { display: inline-block; padding: .15rem .5rem; border-radius: 999px; font-size: .75rem; background: #e5e7eb; }
        .badge.on { background: #d1fae5; color: #065f46; }
        .badge.off { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<header>
    <strong>GegoK12 Site Admin</strong>
    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
</header>
<main>
    <div class="card">
        <h1>Dashboard</h1>
        <p class="muted">Overall admin for {{ config('app.name', 'GegoK12') }}</p>
    </div>
    <div class="card">
        <p><strong>{{ $schools->count() }}</strong> schools · <strong>{{ $schoolAdminCount }}</strong> school admins</p>
    </div>
    <div class="card">
        <h2 style="margin-top:0;font-size:1.1rem">Schools</h2>
        @if($schools->isEmpty())
            <p class="muted">No schools yet. Run full seeders or create a school via the installer / admin tools.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schools as $school)
                        <tr>
                            <td>{{ $school->id }}</td>
                            <td>{{ $school->name }}</td>
                            <td>
                                <span class="badge {{ (int)$school->status === 1 ? 'on' : 'off' }}">
                                    {{ (int)$school->status === 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $school->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
</body>
</html>
