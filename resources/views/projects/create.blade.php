@extends('layouts.app')

@section('title', isset($project) ? 'Edit Project' : 'Create Project')

@section('content')
<form method="POST" action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}">
    @csrf
    @if(isset($project)) @method('PUT') @endif

    <label>Name</label><br>
    <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}"><br><br>

    <label>Description</label><br>
    <textarea name="description">{{ old('description', $project->description ?? '') }}</textarea><br><br>

    <button>{{ isset($project) ? 'Update' : 'Create' }}</button>
</form>
@endsection
