@extends('layouts.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Profile User - ' . auth()->user()->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
            <small>User Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ auth()->user()->foto }}"
                            alt="User profile picture">
                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                        <p class="text-muted text-center">{{ auth()->user()->level === 1 ? 'Administrator' : 'Kasir' }}</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                {{-- <b>Followers</b> <a class="pull-right">1,322</a> --}}
                            </li>

                        </ul>
                        <div>
                            <input type="file" name="file" id="ChangeUserPictureFile" style="display: none"
                                onchange="this.dispatchEvent(new InputEvent('input'))">
                            <a href="#" class="btn btn-primary btn-block"
                                onclick="event.preventDefault();document.getElementById('ChangeUserPictureFile').click();"><b>Ganti
                                    Photo</b></a>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user-detail" data-toggle="tab" aria-expanded="true">User Detail</a>
                        </li>
                        <li class=""><a href="#change-password" data-toggle="tab" aria-expanded="false">Change
                                Password</a></li>

                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="user-detail">
                            <form role="form" action="{{ route('change-profile') }}" method="POST">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ auth()->user()->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ auth()->user()->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="change-password">
                            <form role="form" action="{{ route('change-password') }}" method="POST">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input type="password" class="form-control" name="current_password">
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="new_password">
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('#ChangeUserPictureFile').ijaboCropTool({
            preview: '.image-previewer',
            setRatio: 1,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CROP', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: '{{ route('change-profile-picture') }}',
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                location.reload();
                // toastr.success(message);
            },
            onError: function(message, element, status) {
                toastr.error(message);
            }
        });
    </script>
@endpush
