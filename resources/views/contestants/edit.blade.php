@extends('layouts.app')

@section('title', '| Edit Contestant')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Edit Contestant</h1>
            <hr>
            @include ('errors.list')
            {{ Form::model($contestant, array('route' => array('contestants.update', $contestant->id), 'method' => 'PUT', 'files' => TRUE )) }}
            <fieldset>
                <legend>Individual Details</legend>

                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::text('email', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('age', 'Age') }}
                    {{ Form::number('age', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('sex', 'Sex') }}
                    {{ Form::select('sex', ['M' => 'Male', 'F' => 'Female', 'O' => 'Other'], null, ['placeholder' => 'Select One...', 'class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('picture', 'Picture') }}
                    {{ Form::file('picture', NULL, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('group_id', 'Group') }}
                    {{ Form::select('group_id', $groups, null, ['placeholder' => 'Select One...', 'class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('den_id', 'Den') }}
                    {{ Form::select('den_id', $dens, null, ['placeholder' => 'Select One...', 'class' => 'form-control']) }}
                </div>

            </fieldset>

            <fieldset>
                <legend>Car Details</legend>

                <div class="form-group">
                    {{ Form::label('car_name', 'Car Name') }}
                    {{ Form::text('car_name', NULL, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('car_number', 'Car Number') }}
                    {{ Form::number('car_number', NULL, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('car_picture', 'Car Picture') }}
                    {{ Form::file('car_picture', null, array('class' => 'form-control')) }}
                </div>
            </fieldset>

            <fieldset>
                <legend>Flags for Derby</legend>

                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('car_passed_inspection', 1, $contestant->car_passed_inspection, array( 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'success', 'data-offstyle' => 'danger' ) ) }}
                        Car Passed Inspection
                    </label>
                </div>

                {{--<div class="checkbox">--}}
                    {{--<label>--}}
                        {{--{{ Form::checkbox('exclude', 1, $contestant->exclude, array( 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'danger', 'data-offstyle' => 'success' ) ) }}--}}
                        {{--Exclude From Race--}}
                    {{--</label>--}}
                {{--</div>--}}

                {{--<div class="checkbox">--}}
                    {{--<label>--}}
                        {{--{{ Form::checkbox('present', 1, $contestant->present, array( 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'success', 'data-offstyle' => 'danger' ) ) }}--}}
                        {{--Present--}}
                    {{--</label>--}}
                {{--</div>--}}
            </fieldset>

            <div class="form-group">
                {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection