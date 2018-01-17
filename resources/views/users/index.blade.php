@extends('layouts.app')

@section('title', '| Users')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1>
        <i class="fa fa-users"></i> User Administration

        <div class="btn-group pull-right" role="group">
            <a href="{{ route('roles.index') }}" class="btn btn-default"><i class="fa fa-key"></i> Roles</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default"><i class="fa fa-key"></i> Permissions</a>
        </div>
    </h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date/Time Added</th>
                    <th>User Roles</th>
                    <th>Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="text-center"><img src="{{ gravatar( $user->email, 25 ) }}"> </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}

                    <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add User</a>

</div>

@endsection