@extends('layouts.web')

@section('content')



<div class="container mt-2">
    <div class="card border-secondary p-1  mb-3">
    @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{session('success')}}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (session('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error</strong> {{session('errors')}}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        <div class="card-body">
            <h2 class="card p-2 m-auto">Recurring Task</h2>
            <div class="d-flex row row-cols-1 row-cols-md-3 g-4 container">
            @if (@$recurringsubtasks->isempty())
                <h4 class="p-3">No Task for Today is Available</h4>
                
                @endif    
            <!-- <div class="col"> -->
               
                @foreach (@$recurringsubtasks as $subtask)
               
                <div class="col">
                    <div class="card m-2 card-hover-effect" style="width: 100%;">
                        <div class="card-header">
                            <a href="{{url('/task', @$subtask['task']['id'])}}" style="text-decoration:none; color:black;">
                                <h5 class="fw-bold">{{ @$subtask['task']['title'] }}</h5>
                            </a>
                        </div>
                        <a href="{{route('subtask.view', ['task_id'=>@$subtask['task']['id'], 'subtask_id'=>@$subtask['id']])}}" class="text-decoration-none text-dark">  
                        <div class="card-body">
                                <h5 class="card-title">
                                    {{ @$subtask['title'] }}
                                </h5>
                                <p class="card-text">{{ @$subtask['description'] }}</p>
                            </div>
                        </a>
                        <div class="card-footer">
                        @if (@$subtask['status_id']==1)
                                <div class="badge text-bg-warning rounded-pill fs-6">Pending</div>
                                @elseif(@$subtask['status_id']==2)
                                <div class="badge text-bg-success rounded-pill fs-6">In Progress</div>
                                @elseif(@$subtask['status_id']==3)
                                <div class="badge text-bg-primary rounded-pill fs-6">Completed</div>
                                @elseif(@$subtask['status_id']==4)
                                <div class="badge text-bg-secondary rounded-pill fs-6">Blocked</div>
                                @elseif(@$subtask['status_id']==5)
                                <div class="badge text-bg-danger rounded-pill fs-6">Overdue</div>
                                @endif
                                <span style="float:right;"> {{ @$subtask['days'] }}</span>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="card border-secondary p-1  mb-3">
        <div class="card-body">
            <h2 class="card p-2 m-auto">One-Time Task</h2>
            <div class="d-flex row row-cols-1 row-cols-md-3 g-4 container">
                
            @if (@$one_timesubtasks->isempty())
                <h4 class="p-3">No Task is Available</h4>
                
                @endif
                <!-- <div class="col"> -->
                @foreach (@$one_timesubtasks as $subtask)
                <div class="col">
                    <div class="card m-2 card-hover-effect" style="width: 100%;">
                        <div class="card-header">
                            <a href="{{url('/task', @$subtask['task']['id'])}}" style="text-decoration:none; color:black;">
                                <h5 class="fw-bold">{{ @$subtask['task']['title'] }}</h5>
                            </a>
                        </div>
                        <a href="{{route('subtask.view', ['task_id'=>@$subtask['task']['id'], 'subtask_id'=>@$subtask['id']])}}" class="text-decoration-none text-dark">  
                        <div class="card-body">
                                <h5 class="card-title">
                                    {{ @$subtask['title'] }}
                                </h5>
                                <p class="card-text">{{ @$subtask['description'] }}</p>
                            </div>
                            </a>
                        <div class="card-footer">
                            <div class="">
                                @if (@$subtask['status_id']==1)
                                <div class="badge text-bg-warning rounded-pill fs-6">Pending</div>
                                @elseif(@$subtask['status_id']==2)
                                <div class="badge text-bg-success rounded-pill fs-6">In Progress</div>
                                @elseif(@$subtask['status_id']==3)
                                <div class="badge text-bg-primary rounded-pill fs-6">Completed</div>
                                @elseif(@$subtask['status_id']==4)
                                <div class="badge text-bg-secondary rounded-pill fs-6">Blocked</div>
                                @elseif(@$subtask['status_id']==5)
                                <div class="badge text-bg-danger rounded-pill fs-6">Overdue</div>
                                @endif
                                <span style="float:right;"><b> Deadline:</b> {{ @$subtask['deadline'] }}</span>

                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

</div>

@endsection