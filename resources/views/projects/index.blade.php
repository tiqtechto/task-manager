@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<a class="link-btn" href="{{ route('projects.create') }}">➕ Create Project</a>
</br>
@if($projects->count() == 0)
<p style="margin: 8px 5px;">No Projects found !</p>
@else
<table border="1" cellspacing="0">
    <thead>
        <tr>
            <th>Project</th>
            <th>Description</th>
            <th>Tasks</th>
            <th>Completed %</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($projects as $project)
        @php
            $total = $project->tasks->count();
            $completed = $project->tasks->where('status', 'completed')->count();
            $percent = $total ? round(($completed / $total) * 100, 1) : 0;
        @endphp
        <tr>
            <td>{{ $project->name }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $total }}</td>
            <td>{{ $percent }}%</td>
            <td>
                <a href="{{ route('projects.show', $project) }}">📂 View</a> |
                <a href="{{ route('projects.edit', $project) }}">✏️ Edit</a> |
                <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete project?')">❌</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
@endsection
