@extends('layouts.web')
@section('content')
<div class="container">
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
    <div class="profile-page">

        <div class="content">

            <div class="content__cover">
                <div class="content__avatar">
                    <img src="{{asset('storage/images/task.png')}}">
                </div>

            </div>
            <div class="content__actions">
                <span> </span>
                <span>

                    <button type="button" class="btn edit  m-1" data-bs-toggle="modal" data-bs-target="#editprofile">
                        Edit profile
                    </button>


                    <!-- Edit Profile Modal -->
                    <div class="modal fade" id="editprofile" data-bs-keyboard="false" tabindex="-3" aria-labelledby="editprofilelabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editprofilelabel">Edit Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('profile.update', @$user['id']) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <label class="form-label mt-2">Name :</label>
                                        <input type="text" class="form-control" name="name" value="{{ @$user['name'] }}" placeholder="Name">

                                        <label class="form-label mt-2">Email :</label>
                                        <input type="email" class="form-control" name="email" value="{{ @$user['email'] }}" placeholder="Email" readonly>
                                        <label class="form-label mt-2">Contact Number :</label>
                                        <input type="number" class="form-control" name="contact" value="{{ @$user['contact'] }}" placeholder="Contact Number">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </span>

            </div>
            <div class="content__title">
                <h1>{{@$user['name']}}</h1><span>{{@$user['address']}}</span>
            </div>
            <div class="content__description">
                <p>{{@$user['designation']}}</p>
                <p>{{@$user['email']}}</p>
                <p>
                    @if(@$user['contact']!= null) +91 {{@$user['contact']}}
                    @endif
                </p>
            </div>
            <ul class="content__list">
                <li><span>{{@$task}}</span>Total Tasks</li>
                <li><span>{{@$completedtask}}</span>Completed Tasks</li>
                <li><span>{{@$pendingtask}}</span>Pending Tasks</li>
                <li><span>{{@$inprogresstask}}</span>In Progress Tasks</li>
            </ul>

        </div>
        <div class="">
            <div><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>
    </div>
</div>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('editprofile'), {
        backdrop: false
    });
</script>

@endsection