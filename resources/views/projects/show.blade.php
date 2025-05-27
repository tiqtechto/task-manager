@extends('layouts.app')

@section('title', $project->name)

@section('content')
<p><strong>Description:</strong> {{ $project->description }}</p>
<a class="link-btn" href="{{ route('projects.tasks.create', $project) }}">➕ Add Task</a>

<form style="margin: 8px 0px;" method="GET">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    <select name="status">
        <option value="">All</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
    <button>Filter</button>
</form>

<table border="1" cellspacing="0">
    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Toggle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $index => $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td class="status" data-id="{{ $task->id }}">{{ ucfirst($task->status) }}</td>
            <td>{{ $task->due_date }}</td>
            <td>
                <button class="toggle-status" data-id="{{ $task->id }}">{{ $task->status }}</button>
            </td>
            <td>
                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}">✏️</a>
                <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">❌</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script> console.log('my-url::',location.href);
document.querySelectorAll('.toggle-status').forEach(button => {
    button.addEventListener('click', () => {
        fetch(`../tasks/${button.dataset.id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => { 
            button.textContent = data.status;
            button.closest('tr').querySelector('.status').textContent = data.status;
        });
    });
});
</script>
@endsection
