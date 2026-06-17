<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Student Absence Management System' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    @auth
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-slate-200 bg-white lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between px-5 py-4 lg:block">
                    <div>
                        <p class="text-sm font-semibold text-blue-700">Student Absence</p>
                        <h1 class="text-lg font-bold">Management System</h1>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 lg:mt-4 lg:inline-block">
                        {{ auth()->user()->role }}
                    </span>
                </div>
                <nav class="flex gap-2 overflow-x-auto px-4 pb-4 lg:block lg:space-y-1 lg:overflow-visible">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">Dashboard</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('groups.index') }}" class="nav-link {{ request()->routeIs('groups.*') ? 'nav-link-active' : '' }}">Groups</a>
                    @endif
                    <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'nav-link-active' : '' }}">Students</a>
                    <a href="{{ route('attendances.index') }}" class="nav-link {{ request()->routeIs('attendances.*') ? 'nav-link-active' : '' }}">Attendance</a>
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'nav-link-active' : '' }}">PDF Reports</a>
                </nav>
                <div class="border-t border-slate-200 p-4">
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="mb-3 text-xs text-slate-500">{{ auth()->user()->email }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn-secondary w-full justify-center">Logout</button>
                    </form>
                </div>
            </aside>
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @include('layouts.flash')
                @yield('content')
            </main>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
