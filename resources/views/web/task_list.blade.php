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
                <h2 class="mt-2 text-center"><u>All Tasks</u> <span style="float:right;">
                        <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#addtask">
                            + Add New task
                        </button>
                    </span></h2>
                <!-- Add New task Modal -->
                <div class="modal fade" id="addtask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addtask" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addtask">Add New task</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route('add.task')}}" method="post" class="">
                                @csrf
                                <div class="modal-body">
                                    <label class="form-label mt-2">Title :</label>
                                    <input type="text" class="form-control" value="" name="title" placeholder="Title">

                                    <label class="form-label mt-2">Description :</label>
                                    <textarea type="text" class="form-control" value="" name="description" rows="3" placeholder="Description"></textarea>


                                    <!-- Deadline Field (Initially Hidden) -->
                                    <div id="deadlineField" class="mt-2">
                                        <label class="form-label">Deadline :</label>
                                        <input type="date" class="form-control" value="" name="deadline" placeholder="Deadline">
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

                <div class="subtask-table table-responsive">
                    <table class="table table-bordered">

                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($task as $tasks)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a class="text-decoration-none text-dark fw-bold" href="{{route('task.view', @$tasks['id'])}}">{{ $tasks['title'] }}</a></td>
                            <td>
                                @if (@$tasks['status_id']==1)
                                <div class="badge text-bg-warning fs-6">Pending</div>
                                @elseif(@$tasks['status_id']==2)
                                <div class="badge text-bg-success fs-6">In Progress</div>
                                @elseif(@$tasks['status_id']==3)
                                <div class="badge text-bg-primary fs-6">Completed</div>
                                @elseif(@$tasks['status_id']==4)
                                <div class="badge text-bg-secondary fs-6">Blocked</div>
                                @elseif(@$tasks['status_id']==5)
                                <div class="badge text-bg-danger fs-6">Overdue</div>
                                @endif
                            </td>
                            <td>{{ $tasks['deadline'] }}</td>
                            <td>
                                <div class="d-flex justify-content-evenly">
                                    <!-- Edit Button and Modal -->
                                    <button type="button" class="btn edit m-1" data-bs-toggle="modal" data-bs-target="#edittask{{ $tasks['id'] }}">
                                        Edit
                                    </button>
                                    @if(@$tasks['user_id']==Auth::user()['id'])
                                    <!-- Edit Task Modal -->
                                    <div class="modal fade" id="edittask{{ $tasks['id'] }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edittaskLabel{{ $tasks['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="edittaskLabel{{ $tasks['id'] }}">Edit Task</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('update.task', $tasks['id']) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <label class="form-label mt-2">Title :</label>
                                                        <input type="text" class="form-control" name="title" value="{{ $tasks['title'] }}" placeholder="Title">

                                                        <label class="form-label mt-2">Description :</label>
                                                        <textarea class="form-control" name="description" rows="3" placeholder="Description">{{ $tasks['description'] }}</textarea>

                                                        <div id="deadlineField" class="mt-2">
                                                            <label class="form-label">Deadline :</label>
                                                            <input type="date" class="form-control" name="deadline" value="{{ $tasks['deadline'] }}" placeholder="Deadline">
                                                        </div>
                                                        <label class="form-label mt-2">Status :</label>
                                                        <select class="form-select" name="status_id">
                                                            <option value="1" {{ $tasks['status_id'] == 1 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $tasks['status_id'] == 2 ? 'selected' : '' }}>In Progress</option>
                                                            <option value="3" {{ $tasks['status_id'] == 3 ? 'selected' : '' }}>Completed</option>
                                                            <option value="4" {{ $tasks['status_id'] == 4 ? 'selected' : '' }}>Blocked</option>
                                                            <option value="5" {{ $tasks['status_id'] == 5 ? 'selected' : '' }}>Overdue</option>
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
                                    <div class="modal fade" id="edittask{{ $tasks['id'] }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edittaskLabel{{ $tasks['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="edittaskLabel{{ $tasks['id'] }}">Edit Task</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">Only Owner of this Task Can Edit The Task</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Delete Button and Modal -->
                                    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteconfirmation{{ $tasks['id'] }}">
                                        Delete
                                    </button>

                                    <div class="modal fade" id="deleteconfirmation{{ $tasks['id'] }}" tabindex="-1" aria-labelledby="deleteconfirmationLabel{{ $tasks['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="deleteconfirmationLabel{{ $tasks['id'] }}">Delete Task Confirmation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this task?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('delete.task', $tasks['id']) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection