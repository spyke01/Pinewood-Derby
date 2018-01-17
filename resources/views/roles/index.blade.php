@extends('layouts.app')

@section('title', '| Roles')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1>
        <i class="fa fa-key"></i> Roles

        <div class="btn-group pull-right" role="group">
            <a href="{{ route('users.index') }}" class="btn btn-default"><i class="fa fa-users"></i> Users</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default"><i class="fa fa-key"></i> Permissions</a>
        </div>
    </h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{  $role->permissions()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                    <td>
                    <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
                    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ URL::to('roles/create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Role</a>

</div>

@endsection