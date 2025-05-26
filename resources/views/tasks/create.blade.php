@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Create Task')

@section('content')
<form method="POST" action="{{ isset($task) ? route('projects.tasks.update', [$project, $task]) : route('projects.tasks.store', $project) }}">
    @csrf
    @if(isset($task)) @method('PUT') @endif

    <label>Title</label><br>
    <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}"><br><br>

    <label>Description</label><br>
    <textarea name="description">{{ old('description', $task->description ?? '') }}</textarea><br><br>

    <label>Due Date</label><br>
    <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}"><br><br>

    <button>{{ isset($task) ? 'Update' : 'Create' }}</button>
</form>
@endsection
