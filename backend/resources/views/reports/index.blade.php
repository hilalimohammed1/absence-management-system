@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <p class="eyebrow">Exports</p>
        <h2 class="page-title">PDF Reports</h2>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <section class="panel">
        <h3 class="section-title">By Student</h3>
        <form method="GET" action="{{ route('reports.student') }}" class="mt-4 space-y-4">
            <div>
                <label for="student_id" class="form-label">Student</label>
                <select id="student_id" name="student_id" class="form-input" required>
                    <option value="">Select student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn-primary w-full justify-center">Download PDF</button>
        </form>
    </section>

    <section class="panel">
        <h3 class="section-title">By Group</h3>
        <form method="GET" action="{{ route('reports.group') }}" class="mt-4 space-y-4">
            <div>
                <label for="group_id" class="form-label">Group</label>
                <select id="group_id" name="group_id" class="form-input" required>
                    <option value="">Select group</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn-primary w-full justify-center">Download PDF</button>
        </form>
    </section>

    <section class="panel">
        <h3 class="section-title">By Date</h3>
        <form method="GET" action="{{ route('reports.date') }}" class="mt-4 space-y-4">
            <div>
                <label for="date" class="form-label">Date</label>
                <input id="date" name="date" type="date" value="{{ now()->toDateString() }}" class="form-input" required>
            </div>
            <button class="btn-primary w-full justify-center">Download PDF</button>
        </form>
    </section>
</div>
@endsection
