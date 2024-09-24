@extends('layouts.web')

@section('content')
<div class="container">
    <h1 class="text-center">Search Results for : "{{$keys}}"</h1>
    
    <!-- Display Tasks -->
    @if($tasks->isNotEmpty())
        <h2>Search Results from Tasks</h2>
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-6 mb-3">
                    <a href="{{route('task.view', @$task['id'])}}" class="text-decoration-none text-dark">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $task->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $task->description }}</p>
                            <p><strong>Created at:</strong> {{ $task->created_at->format('d M Y') }}</p>
                            
                            <!-- @if($task->subtask->isNotEmpty())
                                <h6>Subtasks:</h6>
                                <ul>
                                    @foreach($task->subtask as $subtask)
                                        <li>{{ $subtask->title }}</li>
                                    @endforeach
                                </ul>
                            @endif -->
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p>No tasks found.</p>
    @endif
    
    <!-- Display SubTasks -->
    @if($subtasks->isNotEmpty())
        <h2>Search Results from Subtasks</h2>
        <div class="row">
            @foreach($subtasks as $subtask)
                <div class="col-md-6 mb-3">
                    <a href="{{route('subtask.view', ['task_id'=>@$subtask['task_id'], 'subtask_id'=>@$subtask['id']])}}" class="text-decoration-none text-dark"> 
                    <div class="card">
                        <div class="card-header">
                            <h5>SubTask: {{ $subtask->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $subtask->description }}</p>
                            <p><strong>Created at:</strong> {{ $subtask->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p>No subtasks found.</p>
    @endif

</div>
@endsection
