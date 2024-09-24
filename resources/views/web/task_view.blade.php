@extends('layouts.web')
@section('content')


<div class="container mt-2">
    <div class="card" style="background-color:#D6E9D2;">
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success</strong> {{session('success')}}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session(key: 'errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error</strong> {{session('errors')}}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <h2 class="text-center m-3">Task Details <span style="float:right;">
                    <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#edittask{{@$task['id']}}">
                        Edit Task
                    </button>
                </span></h2>
            <!-- Edit Task Modal -->
            <div class="modal fade" id="edittask{{ $task['id'] }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edittaskLabel{{ $task['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="edittaskLabel{{ $task['id'] }}">Edit Task</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('update.task', $task['id']) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label class="form-label mt-2">Title :</label>
                                <input type="text" class="form-control" name="title" value="{{ $task['title'] }}" placeholder="Title">

                                <label class="form-label mt-2">Description :</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Description">{{ $task['description'] }}</textarea>

                                <div id="" class="mt-2">
                                    <label class="form-label">Deadline :</label>
                                    <input type="date" class="form-control" name="deadline" min="{{date('Y-m-d')}}" value="{{ $task['deadline'] }}" placeholder="Deadline">
                                </div>
                                <label class="form-label mt-2">Status :</label>
                                <select class="form-select" name="status_id">
                                    <option value="1" {{ $task['status_id'] == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="2" {{ $task['status_id'] == 2 ? 'selected' : '' }}>In Progress</option>
                                    <option value="3" {{ $task['status_id'] == 3 ? 'selected' : '' }}>Completed</option>
                                    <option value="4" {{ $task['status_id'] == 4 ? 'selected' : '' }}>Blocked</option>
                                    <option value="5" {{ $task['status_id'] == 5 ? 'selected' : '' }}>Overdue</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card border-light text-center ">
                                    <h4 class="lh-lg" style="border:none;">Title : {{@$task['title']}}</h4>
                                    <h5 class="lh-lg" style="border:none;">Status :
                                        @if (@$task['status_id']==1)
                                        <div class="badge text-bg-warning fs-6">Pending</div>
                                        @elseif(@$task['status_id']==2)
                                        <div class="badge text-bg-success fs-6">In Progress</div>
                                        @elseif(@$task['status_id']==3)
                                        <div class="badge text-bg-primary fs-6">Completed</div>
                                        @elseif(@$task['status_id']==4)
                                        <div class="badge text-bg-secondary fs-6">Blocked</div>
                                        @elseif(@$task['status_id']==5)
                                        <div class="badge text-bg-danger fs-6">Overdue</div>
                                        @endif
                                    </h5>
                                    <h5 class="lh-lg" style="border:none;">Deadline: {{@$task['deadline']}} </h5>
                                </div>
                            </div>
                            <div class="card col-sm-6 text-center border-light">
                                <h3>Description</h3>
                                {{@$task['description']}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-center mt-3">
                    <h2 class="mt-2">Subtask Details <span style="float:right;">
                            <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#addsubtask">
                                + Add New Subtask
                            </button>
                        </span></h2>

                    <!-- Add New Subtask Modal -->
                    <div class="modal fade" id="addsubtask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addsubtask" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addsubtask">Add New Subtask</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('store.subtask', @$task['id'])}}" method="post" class="">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="user_id" value="{{@$task['user_id']}}">
                                        <label class="form-label mt-2">Title :</label>
                                        <input type="text" class="form-control" value="" name="title" placeholder="Title">

                                        <label class="form-label mt-2">Description :</label>
                                        <textarea type="text" class="form-control" value="" name="description" rows="3" placeholder="Description"></textarea>

                                        <label class="form-label mt-2">Task Type :</label>
                                        <select class="form-select" name="task_type_id" id="taskType" onchange="toggleFields()">
                                            <option value="">Choose...</option>
                                            <option value="1">One-Time</option>
                                            <option value="2">Recurring</option>
                                        </select>
                                        <!-- Deadline Field (Initially Hidden) -->
                                        <div id="deadlineField" class="mt-2" style="display: none;">
                                            <label class="form-label">Deadline :</label>
                                            <input type="date" class="form-control" value="" min="{{date('Y-m-d')}}" name="deadline" placeholder="Deadline">
                                        </div>
                                        <!-- Days Field (Initially Hidden) -->
                                        <div id="daysField" class="card border-dark mt-2" style="display: none;">
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

                    <!-- Recurring Task Table -->
                    <div class="subtask-table table-responsive">
                        <table class="table table-bordered">
                            <caption class="caption-top fs-3">Recurring Task</caption>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Title</th>
                                <th>Status</th>
                                <th>Recurring Days</th>
                                <th>Actions</th>
                            </tr>
                            @foreach ($subtasks as $subtask)
                            @if ($subtask['task_type_id'] == 2)
                            <tr>
                                <!-- <td>{{$loop->iteration}}</td> -->
                                <td><a href="{{route('subtask.view', ['task_id'=>@$task['id'], 'subtask_id'=>@$subtask['id']])}}" class="text-decoration-none text-dark fw-bold"> {{ $subtask['title'] }} </a></td>
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
                                <td>{{ $subtask['days'] }}</td>
                                <td class="d-flex justify-content-evenly">
                                    <button type="button" class="btn edit m-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editsubtask{{ $subtask->id }}"
                                        data-title="{{ $subtask->title }}"
                                        data-description="{{ $subtask->description }}"
                                        data-days="{{ json_encode($subtask->days) }}"
                                        data-status="{{ $subtask->status_id }}">
                                        Edit
                                    </button>
                                    <!-- Edit Subtask Modal -->
                                    <div class="modal fade" id="editsubtask{{ $subtask->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editsubtaskLabel{{ $subtask->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editsubtaskLabel{{ $subtask->id }}">Edit Subtask</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/tasks/'.$task->id.'/update-subtask', $subtask->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <!-- Title Field -->
                                                        <label class="form-label mt-2">Title :</label>
                                                        <input type="text" class="form-control" name="title" value="{{ $subtask->title }}" placeholder="Title">

                                                        <!-- Description Field -->
                                                        <label class="form-label mt-2">Description :</label>
                                                        <textarea class="form-control" name="description" rows="3" placeholder="Description">{{ $subtask->description }}</textarea>
                                                        <input type="hidden" name="task_type_id" value="{{@$subtask['task_type_id']}}">
                                                        <!-- Days Field -->
                                                        <label class="form-label mt-2">Select Days :</label>
                                                        <div class="card border-dark mt-2">
                                                            <div class="card-body lh-lg">
                                                                @php
                                                                // Ensure the days are properly converted to an array
                                                                $savedDays = is_array($subtask->days) ? $subtask->days : explode(',', $subtask->days);
                                                                @endphp

                                                                @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                                                <input type="checkbox" class="btn-check" name="days[]" value="{{ $day }}" id="edit{{ $day }}{{ $subtask->id }}" autocomplete="off"
                                                                    @if(in_array($day, $savedDays)) checked @endif>
                                                                <label class="btn" for="edit{{ $day }}{{ $subtask->id }}">{{ $day }}</label>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Status Field -->
                                                        <label class="form-label mt-2">Status :</label>
                                                        <select class="form-select" name="status_id">
                                                            <option value="1" {{ $subtask->status_id == 1 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $subtask->status_id == 2 ? 'selected' : '' }}>In Progress</option>
                                                            <option value="3" {{ $subtask->status_id == 3 ? 'selected' : '' }}>Completed</option>
                                                            <option value="4" {{ $subtask->status_id == 4 ? 'selected' : '' }}>Blocked</option>
                                                            <option value="5" {{ $subtask->status_id == 5 ? 'selected' : '' }}>Overdue</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->

                                    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteconfirmation{{@$subtask['id']}}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteconfirmation{{@$subtask['id']}}" tabindex="-1" aria-labelledby="deleteconfirmationLabel{{@$subtask['id']}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="deleteconfirmationLabel{{@$subtask['id']}}">Delete Subtask Confirmation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are You Sure, You want to Delete this Subtask ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{route('delete.subtask', ['task_id'=>@$task['id'], 'subtask_id'=>@$subtask['id']])}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger me-2 ">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>

                    <!-- One-Time Task Table -->
                    <div class="subtask-table table-responsive">
                        <table class="table table-bordered">
                            <caption class="caption-top fs-3">One-Time Task</caption>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Title</th>
                                <th>Status</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                            @foreach ($subtasks as $subtask)
                            @if ($subtask['task_type_id'] == 1)
                            <tr>
                                <!-- <td>{{$loop->iteration}}</td> -->
                                <td><a href="{{route('subtask.view', ['task_id'=>@$task['id'], 'subtask_id'=>@$subtask['id']])}}" class="text-decoration-none text-dark fw-bold"> {{ $subtask['title'] }} </a></td>
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
                                <td>{{ $subtask['deadline'] }}</td>
                                <td class="d-flex justify-content-evenly">
                                    <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#editsubtask{{@$subtask['id']}}">
                                        Edit
                                    </button>
                                    <!-- Edit Subtask Modal -->
                                    <div class="modal fade" id="editsubtask{{@$subtask['id']}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editsubtask{{@$subtask['id']}}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editsubtask{{@$subtask['id']}}">Edit Subtask</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/tasks/'.@$task['id'].'/update-subtask',@$subtask['id'])}}" method="post" class="">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <label class="form-label mt-2">Title :</label>
                                                        <input type="text" class="form-control" value="{{@$subtask['title']}}" name="title" placeholder="Title">

                                                        <label class="form-label mt-2">Description :</label>
                                                        <textarea type="text" class="form-control" value="" name="description" rows="3" placeholder="Description">{{@$subtask['description']}}</textarea>
                                                        <input type="hidden" value="{{@$subtask['task_type_id']}}" name="task_type_id">
                                                        <!-- Deadline Field (Initially Hidden) -->
                                                        <div id="" class="mt-2">
                                                            <label class="form-label">Deadline :</label>
                                                            <input type="date" class="form-control" min="{{date('Y-m-d')}}" value="{{@$subtask['deadline']}}" name="deadline" placeholder="Deadline">
                                                        </div>

                                                        <label class="form-label mt-2">Status :</label>
                                                        <select class="form-select" name="status_id">
                                                            <option value="1" {{ $subtask->status_id == 1 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $subtask->status_id == 2 ? 'selected' : '' }}>In Progress</option>
                                                            <option value="3" {{ $subtask->status_id == 3 ? 'selected' : '' }}>Completed</option>
                                                            <option value="4" {{ $subtask->status_id == 4 ? 'selected' : '' }}>Blocked</option>
                                                            <option value="5" {{ $subtask->status_id == 5 ? 'selected' : '' }}>Overdue</option>
                                                        </select>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Confirmation Modal -->

                                    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteconfirmation{{ $subtask['id'] }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteconfirmation{{@$subtask['id']}}" tabindex="-1" aria-labelledby="deleteconfirmation{{ $subtask['id'] }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="deleteconfirmation{{ $subtask['id'] }}Label">Delete Subtask Confirmation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are You Sure, You want to Delete this Subtask ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{route('delete.subtask', ['task_id'=>@$task['id'], 'subtask_id'=>@$subtask['id']])}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger me-2 ">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        const taskType = document.getElementById('taskType').value;
        const deadlineField = document.getElementById('deadlineField');
        const daysField = document.getElementById('daysField');
        if (taskType == '1') { // One-Time task
            deadlineField.style.display = 'block';
            daysField.style.display = 'none';
            console.log('deadline');
        } else if (taskType == '2') { // Recurring task
            deadlineField.style.display = 'none';
            daysField.style.display = 'block';
            console.log('days');

        } else { // No task type selected
            deadlineField.style.display = 'none';
            daysField.style.display = 'none';
            console.log('none');

        }
    }
</script>
@endsection