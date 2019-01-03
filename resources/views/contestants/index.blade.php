@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-address-book"></i> Contestants</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Car Name</th>
                    <th>Car #</th>
                    <th>Group</th>
                    <th>Den</th>
                    <th>Inspected?</th>
                    {{--<th>Excluded?</th>--}}
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if ( count($contestants) )
                    @foreach ($contestants as $contestant)
                        <tr>
                            <td class="text-center">
                                @if ( !empty( $contestant->picture) )
                                    <img src="{{ asset( 'storage/' . $contestant->picture ) }}" class="img-responsive center-block max-w-100" alt="" />
                                @endif
                            </td>
                            <td>{{ $contestant->name }}</td>
                            <td>{{ $contestant->car_name }}</td>
                            <td>
                                {{ Form::number('car_number', $contestant->car_number, array( 'class' => 'form-control quickNumberCar', 'data-id' => $contestant->id  ) ) }} <i class="fa fa-circle-o-notch fa-spin spinner hidden" ></i>
                            </td>
                            <td>
                                @if ( !empty( $contestant->group_picture) )
                                    <img src="{{ asset( 'storage/' . $contestant->group_picture ) }}" class="img-responsive center-block max-w-50" alt="" />
                                @elseif ( isset( $contestant->group_name) )
                                    {{ $contestant->group_name }}
                                @endif
                            </td>
                            <td>
                                @if ( !empty( $contestant->den_picture) )
                                    <img src="{{ asset( 'storage/' . $contestant->den_picture ) }}" class="img-responsive center-block max-w-50" alt="" />
                                @elseif ( isset( $contestant->den_name) )
                                    {{ $contestant->den_name }}
                                @endif
                            </td>
                            <td>
                                {{ Form::checkbox('car_passed_inspection', 1, $contestant->car_passed_inspection, array( 'class' => 'carPassedInspectionToggle', 'data-id' => $contestant->id, 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'success', 'data-offstyle' => 'danger' ) ) }} <i class="fa fa-circle-o-notch fa-spin spinner hidden" ></i>
                            </td>
                            {{--<td>--}}
                                {{--{{ Form::checkbox('exclude', 1, $contestant->exclude, array( 'class' => 'carExcludedToggle', 'data-id' => $contestant->id, 'data-toggle' => 'toggle', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'danger', 'data-offstyle' => 'success' ) ) }} <i class="fa fa-circle-o-notch fa-spin spinner hidden" ></i>--}}
                            {{--</td>--}}
                            <td>
                                <a href="{{ route('contestants.edit', $contestant->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['contestants.destroy', $contestant->id] ]) !!}
                                <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any contestants, you should add some.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        <a href="{{ route('contestants.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Contestant</a>

    </div>
@endsection