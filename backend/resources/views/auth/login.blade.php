@extends('layouts.app')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-10">
    <div class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Student Absence Management System</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-950">Sign in</h1>
            <p class="mt-2 text-sm text-slate-600">Use your admin or teacher account to continue.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-input" required autofocus>
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" class="form-input" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-700">
                Remember me
            </label>
            <button class="btn-primary w-full justify-center">Login</button>
        </form>
    </div>
</div>
@endsection
