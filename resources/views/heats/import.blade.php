@extends('layouts.app')

@section('title', '| Create New Heat')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Import Heats</h1>
            <hr>
            {{-- @include ('errors.list') --}}

            {{-- Using the Laravel HTML Form Collective to create our form --}}
            {{ Form::open( array( 'route' => 'heats.store', 'files' => true ) ) }}

            <div class="form-group">
                {{ Form::label('group_id', 'Group') }}
                {{ Form::select('group_id', $groups, null, ['placeholder' => 'Select One...', 'class' => 'form-control']) }}
            </div>

            <div class="help-block"><a href="{{asset('storage/imports/heats/template.csv')}}" class="btn btn-info btn-sm"><i class="fa fa-download" ></i> Download Import Template</a></div>
            <div class="form-group">
                {{ Form::label('import_file', 'Import File') }}
                {{ Form::file('import_file', null, array('class' => 'form-control')) }}
            </div>

            <div class="checkbox">
                <label>
                    {{ Form::checkbox('replace_heat', 1, false, array( 'class' => 'replaceHeatToggle', 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'danger', 'data-offstyle' => 'default' ) ) }}
                    Replace Heat Data?
                </label>
            </div>
            <div class="alert alert-danger replaceDataAlert hidden">This will delete all existing heats AND runs for the selected group and re-create them.</div>

            <div class="form-group">
                {{ Form::submit('Create Heat and Runs', array('class' => 'btn btn-success btn-lg btn-block')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection