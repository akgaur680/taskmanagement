@extends('layouts.web')
@section('content')
<div class="container mt-2">
    <div class="card border-secondary p-1  mb-3">
        <div class="card-body">
            <div class="card  mt-3">
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
                <h2 class="mt-2 text-center"><u>All Subtasks List</u> </h2>
                    @foreach (@$task as $tasks )
                    @php
                    $modalId = @$tasks['id'];
                    @endphp
                <div class="card m-1">
                    <div class="card-body">
                        <div class="card">
                            <h3 class="card-header"> <a href="{{route('task.view', @$tasks['id'])}}" class="text-decoration-none text-dark"> {{@$tasks['title']}}</a> <span style="float:right;">
                                    <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#addsubtask-{{@$tasks['id']}}">
                                        + Add New Subtask
                                    </button>
                                </span></h3>
                            @if($tasks['user_id']== Auth::user()['id'])

                            <!-- Add New Subtask Modal -->
                            <div class="modal fade" id="addsubtask-{{@$tasks['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addsubtask-{{@$tasks['id']}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="addsubtask-{{@$tasks['id']}}">Add New Subtask</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('store.subtask', @$tasks['id'])}}" method="post" class="">
                                            @csrf
                                            <div class="modal-body">
                                                <label class="form-label mt-2">Title :</label>
                                                <input type="text" class="form-control" value="" name="title" placeholder="Title">
                                                <label class="form-label mt-2">Description :</label>
                                                <textarea type="text" class="form-control" value="" name="description" rows="3" placeholder="Description"></textarea>
                                                <label class="form-label mt-2">Task Type :</label>
                                                <select class="form-select" name="task_type_id" id="taskType-{{$modalId}}" onchange="toggleFields('{{$modalId}}')">
                                                    <option value="">Choose...</option>
                                                    <option value="1">One-Time</option>
                                                    <option value="2">Recurring</option>
                                                </select>
                                                <!-- Deadline Field (Initially Hidden) -->
                                                <div id="deadlineField-{{$modalId}}" class="mt-2" style="display: none;">
                                                    <label class="form-label">Deadline :</label>
                                                    <input type="date" class="form-control" min="{{ date('Y-m-d') }}" value="" name="deadline" placeholder="Deadline">

                                                </div>
                                                <!-- Days Field (Initially Hidden) -->
                                                <div id="daysField-{{$modalId}}" class="card border-dark mt-2" style="display: none;">
                                                    <div class="card-body lh-lg">
                                                        <label class="form-label">Select Days :</label>
                                                        <br>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Sunday" id="sunday" autocomplete="off">
                                                        <label class="btn" for="sunday">Sunday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Monday" id="monday" autocomplete="off">
                                                        <label class="btn" for="monday">Monday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Tuesday" id="tuesday" autocomplete="off">
                                                        <label class="btn" for="tuesday">Tuesday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Wednesday" id="wednesday" autocomplete="off">
                                                        <label class="btn" for="wednesday">Wednesday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Thursday" id="thursday" autocomplete="off">
                                                        <label class="btn" for="thursday">Thursday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Friday" id="friday" autocomplete="off">
                                                        <label class="btn" for="friday">Friday</label>
                                                        <input type="checkbox" class="btn-check" name="days[]" value="Saturday" id="saturday" autocomplete="off">
                                                        <label class="btn" for="saturday">Saturday</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="modal fade" id="addsubtask-{{@$tasks['id']}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addsubtaskLabel-{{@$tasks['id']}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="addsubtaskLabel-{{@$tasks['id']}}">Add New Subtask</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">Only Owner of this Task Can Add New Task.</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-6 table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <caption class="caption-top fw-bold">Recurring Tasks</caption>
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Recurring Days</th>
                                        </tr>
                                    </thead>
                                    @if ($tasks['subtask'] && $tasks['subtask']->isNotEmpty())
                                    @foreach ($tasks['subtask'] as $subtask)
                                    @if ($subtask['task_type']['id'] == 2)
                                    <tbody>
                                        <tr>
                                            <td><a href="{{route('subtask.view', ['task_id'=>@$subtask['task_id'], 'subtask_id'=>@$subtask['id']])}}"> {{ $subtask['title'] }} </a></td>
                                            <td>
                                                @if (@$subtask['status_id']==1)
                                                <div class="badge text-bg-warning fs-6">Pending</div>
                                                @elseif(@$subtask['status_id']==2)
                                                <div class="badge text-bg-success fs-6">In Progress</div>
                                                @elseif(@$subtask['status_id']==3)
                                                <div class="badge text-bg-primary fs-6">Completed</div>
                                                @elseif(@$subtask['status_id']==4)
                                                <div class="badge text-bg-secondary fs-6">Blocked</div>
                                                @elseif(@$subtask['status_id']==5)
                                                <div class="badge text-bg-danger fs-6">Overdue</div>
                                                @endif
                                            </td>
                                            <td> {{$subtask['days']}} </td>
                                        </tr>
                                    </tbody>
                                    @endif
                                    @endforeach
                                    @else
                                    <tbody>
                                        <tr>
                                            <td colspan="3">No recurring tasks available</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            <div class="col-sm-6 table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <caption class="caption-top fw-bold">One-Time Tasks</caption>
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Deadline</th>
                                        </tr>
                                    </thead>
                                    @if ($tasks['subtask'] && $tasks['subtask']->isNotEmpty())
                                    @foreach ($tasks['subtask'] as $subtask)
                                    @if ($subtask['task_type']['id'] == 1)
                                    <tbody>
                                        <tr>
                                            <td><a href="{{route('subtask.view', ['task_id'=>@$subtask['task_id'], 'subtask_id'=>@$subtask['id']])}}"> {{ $subtask['title'] }} </a></td>
                                            <td> @if (@$subtask['status_id']==1)
                                                <div class="badge text-bg-warning fs-6">Pending</div>
                                                @elseif(@$subtask['status_id']==2)
                                                <div class="badge text-bg-success fs-6">In Progress</div>
                                                @elseif(@$subtask['status_id']==3)
                                                <div class="badge text-bg-primary fs-6">Completed</div>
                                                @elseif(@$subtask['status_id']==4)
                                                <div class="badge text-bg-secondary fs-6">Blocked</div>
                                                @elseif(@$subtask['status_id']==5)
                                                <div class="badge text-bg-danger fs-6">Overdue</div>
                                                @endif
                                            </td>
                                            <td> {{$subtask['deadline']}} </td>
                                        </tr>
                                    </tbody>
                                    @endif
                                    @endforeach
                                    @else
                                    <tbody>
                                        <tr>
                                            <td colspan="3">No One-Time tasks available</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    function toggleFields(modalId) {
        const taskType = document.getElementById(`taskType-${modalId}`).value;
        const deadlineField = document.getElementById(`deadlineField-${modalId}`);
        const daysField = document.getElementById(`daysField-${modalId}`);
        if (taskType == '1') { // One-Time task
            deadlineField.style.display = 'block';
            daysField.style.display = 'none';
            console.log(taskType);
        } else if (taskType == '2') { // Recurring task
            deadlineField.style.display = 'none';
            daysField.style.display = 'block';
            console.log(taskType);

        } else { // No task type selected
            deadlineField.style.display = 'none';
            daysField.style.display = 'none';
            console.log(taskType);

        }
    }


</script>

@endsection