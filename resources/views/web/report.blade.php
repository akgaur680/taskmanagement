@extends('layouts.web')

@section('content')
<div class="container">
    <div class="card">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="message">
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
            <h3>Daily Task Report for the Month "{{date('F')}}"
                <span style="float: right;">
                    <button type="button" id="addreport" class="btn edit">Add Daily Work</button>
                </span>
            </h3>
            <!-- Popup Modal HTML (Initially Hidden) -->
            <div class="" id="addreportpopup" style="display: none;">
                <div class="" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                    <div class="card" style="background-color:white; width: 40%; margin: 100px auto; padding: 20px; position: relative; max-height: 80vh; overflow-y: auto;">
                        <h4 class="">Add Daily Work</h4>
                        <form id="dailyWorkForm" action="{{route('report.store')}}" method="post" enctype="multipart/form-data" class="p-1">
                            @csrf
                            <div class="form-group m-2 p-2">
                                <label for="taskDate">Date:</label>
                                <input type="date" id="taskDate" name="date" max="{{date('Y-m-d')}}" min="{{ date('Y-m-d', strtotime('-30 days')) }}" class="form-control">
                            </div>
                            <div class="form-group m-2 p-2">
                                <label for="checkIn">Check In:</label>
                                <input type="time" id="checkIn" name="checkIn" class="form-control">
                            </div>
                            <div class="form-group m-2 p-2">
                                <label for="checkOut">Check Out:</label>
                                <input type="time" id="checkOut" name="checkOut" class="form-control">
                            </div>
                            <div class="form-group m-2 p-2">
                                <label for="project">Project:</label>
                                <input type="text" id="project" name="project" class="form-control">
                            </div>
                            <div class="form-group m-2 p-2">
                                <label for="taskDetails">Task Details:</label>
                                <textarea id="taskDetails" class="form-control" name="taskDetails"></textarea>
                            </div>
                            <div class="form-group m-2 p-2">
                                <label for="remarks">Remarks:</label>
                                <textarea id="remarks" class="form-control" name="remarks"></textarea>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="saveWork" class="btn btn-primary">Save</button>
                                <button type="button" id="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr class="table-warning">
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Project</th>
                            <th>Task Details</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allDates as $dates)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($dates)) }}</td>
                            {{-- Check if the day is Saturday or Sunday --}}
                            @php
                            $dayOfWeek = date('l', strtotime($dates)); // Get the day of the week
                            @endphp
                            @if ($dayOfWeek=='Sunday'|| $dayOfWeek=='Saturday')
                            <td colspan="5" class="text-center text-dark" style="background-color:#d0e0e3;">Weekend</td>
                            <td class="text-center text-dark" style="background-color:#d0e0e3;"></td>
                            @else
                            @if(isset($reports[$dates]))
                            <td>{{@$reports[$dates]['checkIn']}}</td>
                            <td>{{@$reports[$dates]['checkOut']}}</td>
                            <td>{{@$reports[$dates]['project']}}</td>
                            <td>{{@$reports[$dates]['taskDetails']}}</td>
                            <td>{{@$reports[$dates]['remarks']}}</td>
                            <td>
                                <div class="d-flex  gap-2 ">
                                    <button type="button" class="edit btn" data-id="{{ @$reports[$dates]['id'] }}">Edit</button>
                                    <!-- Edit Report Popup -->
                                    <div id="editreportpopup-{{ @$reports[$dates]['id'] }}" style="display: none;">
                                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="card" style="background-color:white; width: 40%; margin: 100px auto; padding: 20px; position: relative; max-height: 80vh; overflow-y: auto;">
                                                <h4>Edit Daily Work</h4>
                                                <form id="dailyWorkForm-{{ @$reports[$dates]['id'] }}" action="{{ route('report.edit', @$reports[$dates]['id']) }}" method="post" enctype="multipart/form-data" class="p-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group m-2 p-2">
                                                        <label for="taskDate">Date:</label>
                                                        <input type="date" id="date" name="date" max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime('-30 days')) }}" class="form-control" value="{{ @$reports[$dates]['date'] }}">
                                                    </div>
                                                    <div class="form-group m-2 p-2">
                                                        <label for="checkIn">Check In:</label>
                                                        <input type="time" name="checkIn" class="form-control" value="{{ @$reports[$dates]['checkIn'] }}">
                                                    </div>
                                                    <div class="form-group m-2 p-2">
                                                        <label for="checkOut">Check Out:</label>
                                                        <input type="time" name="checkOut" class="form-control" value="{{ @$reports[$dates]['checkOut'] }}">
                                                    </div>
                                                    <div class="form-group m-2 p-2">
                                                        <label for="project">Project:</label>
                                                        <input type="text" name="project" class="form-control" value="{{ @$reports[$dates]['project'] }}">
                                                    </div>
                                                    <div class="form-group m-2 p-2">
                                                        <label for="taskDetails">Task Details:</label>
                                                        <textarea class="form-control" name="taskDetails">{{ @$reports[$dates]['taskDetails'] }}</textarea>
                                                    </div>
                                                    <div class="form-group m-2 p-2">
                                                        <label for="remarks">Remarks:</label>
                                                        <textarea class="form-control" name="remarks">{{ @$reports[$dates]['remarks'] }}</textarea>
                                                    </div>
                                                    <div class="card-footer flex justify-between">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="cancel-edit btn btn-secondary" data-id="{{ @$reports[$dates]['id'] }}">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('report.delete', $reports[$dates]['id']) }}" method="post" class="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                            @else
                            <td colspan="5" class="text-center text-danger">No Report Available</td>
                            <td>
                                <!-- Popup Modal to Add empty date report -->
                                <button type="button" class="add-empty-report btn-outline-primary btn" data-date="{{@$dates}}">Add</button>
                                <div class="add-empty-report-popup" id="addemptyreportpopup-{{@$dates}}" style="display:none;">
                                    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                                        <div class="card" style="background-color:white; width: 40%; margin: 100px auto; padding: 20px; position: relative; max-height: 80vh; overflow-y: auto;">
                                            <h4>Add Today's Work</h4>
                                            <form id="dailyWorkemptyForm-{{ @$dates }}" action="{{ route('report.store')}}" method="post" enctype="multipart/form-data" class="p-1">
                                                @csrf
                                                <div class="form-group m-2 p-2">
                                                    <label for="taskDate">Date:</label>
                                                    <input type="date" name="date" max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime('-30 days')) }}" class="form-control" value="{{@$dates}}" readonly>
                                                </div>
                                                <div class="form-group m-2 p-2">
                                                    <label for="checkIn">Check In:</label>
                                                    <input type="time" name="checkIn" class="form-control">
                                                </div>
                                                <div class="form-group m-2 p-2">
                                                    <label for="checkOut">Check Out:</label>
                                                    <input type="time" name="checkOut" class="form-control">
                                                </div>
                                                <div class="form-group m-2 p-2">
                                                    <label for="project">Project:</label>
                                                    <input type="text" name="project" class="form-control">
                                                </div>
                                                <div class="form-group m-2 p-2">
                                                    <label for="taskDetails">Task Details:</label>
                                                    <textarea class="form-control" name="taskDetails"></textarea>
                                                </div>
                                                <div class="form-group m-2 p-2">
                                                    <label for="remarks">Remarks:</label>
                                                    <textarea class="form-control" name="remarks"></textarea>
                                                </div>
                                                <div class="card-footer flex justify-between">
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                    <button type="button" class="cancel-add btn btn-secondary" data-date="{{ @$dates }}">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif

                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection