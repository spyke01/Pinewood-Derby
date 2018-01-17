@extends('layouts.app')

@section('title', '| Permissions')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1>
        <i class="fa fa-key"></i> Available Permissions

        <div class="btn-group pull-right" role="group">
            <a href="{{ route('users.index') }}" class="btn btn-default"><i class="fa fa-users"></i> Users</a>
            <a href="{{ route('roles.index') }}" class="btn btn-default"><i class="fa fa-key"></i> Roles</a>
        </div>
    </h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td> 
                    <td>
                    <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
                    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ URL::to('permissions/create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Permission</a>

</div>

@endsection