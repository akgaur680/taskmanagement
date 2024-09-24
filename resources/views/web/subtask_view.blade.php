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
            @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error</strong> {{session('errors')}}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <h2 class="text-center m-3">Subtask Details
                <span style="float:right;"> <button type="button" class="btn edit m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#editsubtask{{ $subtask['id'] }}"
                        data-title="{{ $subtask['title'] }}"
                        data-description="{{ $subtask['description'] }}"
                        data-days="{{ json_encode($subtask['days']) }}"
                        data-status="{{ $subtask['status_id'] }}">
                        Edit
                    </button></span>

            </h2>
            @if(@$subtask['user_id']== Auth::user()['id'])

            <!-- Edit Subtask Modal -->
            <div class="modal fade" id="editsubtask{{ $subtask['id'] }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editsubtaskLabel{{ $subtask['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editsubtaskLabel{{ $subtask['id'] }}">Edit Subtask</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('update.subtask', ['task_id'=>@$subtask['task_id'], 'subtask_id'=>@$subtask['id']]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <!-- Title Field -->
                                <label class="form-label mt-2">Title :</label>
                                <input type="text" class="form-control" name="title" value="{{ $subtask['title'] }}" placeholder="Title">

                                <!-- Description Field -->
                                <label class="form-label mt-2">Description :</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Description">{{ $subtask['description'] }}</textarea>
                                <input type="hidden" name="task_type_id" value="{{@$subtask['task_type_id']}}">
                                <!-- Days Field -->
                                <label class="form-label mt-2">Select Days :</label>
                                <div class="card border-dark mt-2">
                                    <div class="card-body lh-lg">
                                        @php
                                        // Ensure the days are properly converted to an array
                                        $savedDays = is_array($subtask['days']) ? $subtask['days'] : explode(',', $subtask['days']);
                                        @endphp

                                        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                        <input type="checkbox" class="btn-check" name="days[]" value="{{ $day }}" id="edit{{ $day }}{{ $subtask['id'] }}" autocomplete="off"
                                            @if(in_array($day, $savedDays)) checked @endif>
                                        <label class="btn" for="edit{{ $day }}{{ $subtask['id'] }}">{{ $day }}</label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Status Field -->
                                <label class="form-label mt-2">Status :</label>
                                <select class="form-select" name="status_id">
                                    <option value="1" {{ $subtask['status_id'] == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="2" {{ $subtask['status_id'] == 2 ? 'selected' : '' }}>In Progress</option>
                                    <option value="3" {{ $subtask['status_id'] == 3 ? 'selected' : '' }}>Completed</option>
                                    <option value="4" {{ $subtask['status_id'] == 4 ? 'selected' : '' }}>Blocked</option>
                                    <option value="5" {{ $subtask['status_id'] == 5 ? 'selected' : '' }}>Overdue</option>
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
            @else
            <div class="modal fade" id="editsubtask{{ $subtask['id'] }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editsubtaskLabel{{ $subtask['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editsubtaskLabel{{ $subtask['id'] }}">Edit Subtask</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Only Owner of this Task Can Edit the Task.</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card border-light text-center ">
                                    <h4 class="lh-lg" style="border:none;">Title : {{@$subtask['title']}}</h4>
                                    <h5 class="lh-lg" style="border:none;">Status :
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
                                    </h5>
                                    @if(@$subtask['task_type_id']==2)
                                    <h5 class="lh-lg" style="border:none;">Days: {{@$subtask['days']}} </h5>
                                    @else
                                    <h5 class="lh-lg" style="border:none;">Deadline: {{@$subtask['deadline']}} </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="card col-sm-6 text-center border-light">
                                <h3>Description</h3>
                                {{@$subtask['description']}}
                            </div>
                        </div>
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
        } else if (taskType == '2') { // Recurring task
            deadlineField.style.display = 'none';
            daysField.style.display = 'block';
        } else { // No task type selected
            deadlineField.style.display = 'none';
            daysField.style.display = 'none';
        }
    }
</script>

@endsection