@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Overview</p>
        <h2 class="text-2xl font-bold text-slate-950">Dashboard</h2>
    </div>
    <a href="{{ route('attendances.index') }}" class="btn-primary">Mark Attendance</a>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="stat-card"><span>Total Students</span><strong>{{ $totalStudents }}</strong></div>
    <div class="stat-card"><span>Total Groups</span><strong>{{ $totalGroups }}</strong></div>
    <div class="stat-card"><span>Total Absences</span><strong>{{ $totalAbsences }}</strong></div>
    <div class="stat-card"><span>Absence Rate</span><strong>{{ $absenceRate }}%</strong></div>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="panel">
        <h3 class="section-title">Absences By Group</h3>
        <div class="space-y-4">
            @forelse($absencesByGroup as $group)
                @php
                    $max = max($absencesByGroup->max('absences_count'), 1);
                    $width = round(($group->absences_count / $max) * 100);
                @endphp
                <div>
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium">{{ $group->group_name }}</span>
                        <span class="text-slate-500">{{ $group->absences_count }} absences</span>
                    </div>
                    <div class="h-3 rounded-full bg-slate-100">
                        <div class="h-3 rounded-full bg-blue-700" style="width: {{ $width }}%"></div>
                    </div>
                </div>
            @empty
                <p class="empty-text">No group statistics yet.</p>
            @endforelse
        </div>
    </section>

    <section class="panel">
        <h3 class="section-title">Recent Daily Absences</h3>
        <div class="space-y-3">
            @forelse($dailyStats as $stat)
                <div class="flex items-center justify-between rounded-md bg-slate-50 px-4 py-3">
                    <span class="text-sm font-medium">{{ $stat->date }}</span>
                    <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">{{ $stat->absent_count }}</span>
                </div>
            @empty
                <p class="empty-text">Attendance has not been saved yet.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
