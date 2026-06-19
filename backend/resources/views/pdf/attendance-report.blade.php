<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { color: #111827; font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 22px; margin-bottom: 4px; }
        .subtitle { color: #4b5563; margin-bottom: 24px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #eff6ff; color: #1d4ed8; text-align: left; }
        th, td { border: 1px solid #d1d5db; padding: 8px; }
        .badge { border-radius: 999px; font-weight: bold; padding: 3px 8px; }
        .present { background: #dcfce7; color: #166534; }
        .absent { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="subtitle">{{ $subtitle }} | Generated on {{ now()->format('Y-m-d H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Group</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date->format('Y-m-d') }}</td>
                    <td>{{ $attendance->student->full_name }}</td>
                    <td>{{ $attendance->student->group->group_name }}</td>
                    <td>
                        <span class="badge {{ strtolower($attendance->status) }}">
                            {{ $attendance->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
