@extends('layouts.dashboard')
@section('page_heading','Exam Schedule')
@section('section')

    @if(Session::has('exam_status'))
        {{--<div style="width:100%; text-align: center;" class="alert {{ Session::get('alert-class') }}">--}}
            {{--{{ Session::get('exam_status') }}--}}
        {{--</div>--}}

        @php
            $examStatus = Session::get('exam_status');
            echo "<script type='text/javascript'>alert('$examStatus');</script>";
        @endphp
    @endif

<div class="col-sm-12">

    <div class="col-sm-12">
        <div class="form-group ">
            <a href="{{route('exam_schedule_view')}}" class="btn btn-primary ">
                <i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <table class="table table-bordered table-striped" id="tblSearch">
        <thead>
        <tr>
            <th class="">Exam Schedule</th>
            <th class="">Start Date</th>
            <th class="">Time</th>
            <th class="">Description</th>
        </tr>
        </thead>
        <tbody>
            @if(isset($schedule))
            <tr>
                <td>{{ $schedule->examName['name'] }}</td>
                <!-- <td>{{ $schedule->date }}</td> -->

                <td>
                    @if(!empty($schedule->date))
                        {{Carbon\Carbon::parse($schedule->date)->format('d-m-Y')}}
                        @else
                        {{ $schedule->date }}
                        @endif
                </td>

                <!-- <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td> -->
                <td>
                    @if(isset($schedule->start_time) && !empty($schedule->start_time))
                        {{Carbon\Carbon::parse($schedule->start_time)->format('h:i a')
                     }}
                    @endif

                    {{(!empty($schedule->start_time) && !empty($schedule->end_time) ? '-':'')}}

                    @if(isset($schedule->end_time) && !empty($schedule->end_time))
                            {{Carbon\Carbon::parse($schedule->end_time)->format('h:i a')
                         }}
                    @endif

                </td>
                <td>{{ $schedule->examName['description'] }}</td>
            </tr>
            @endif
        </tbody>
    </table>



    <div class="col-sm-12" style="padding-left: 0px;">
        <h2 style="float: left;" >Exameen List</h2>
        <div class="col-sm-3" style="  padding: 0px;  padding-left: 20px; margin-top: 20px;">
            <div class="pull-left">
                <a href="{{ route('schedule_exameen_update_view', $schedule->id)}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Examinee</a>
            </div>
        </div>
        <hr style="float: left; width: 100%;">
    </div>
    <form action="{{ route('change_exameen_exam_status_action', $schedule->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="table table-bordered table-striped" id="tblSearch">
        <thead>
            <tr>
                <th class="">Serial</th>
                <th class="">Name</th>
                {{--<th class="">Schedule Name</th>--}}
                <th class="">Mobile No</th>
                <th class="">Email</th>
                <th class="">Thana</th>
                <th class="">Exam Status</th>
                <th class="">Action</th>
            </tr>
        </thead>
        <tbody>
        @php($i=1)

            @foreach($exameen as  $exameen)
                @if(isset($exameen->exameen))
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{ $exameen->exameen->first_name }} {{ $exameen->exameen->last_name }}</td>
                        <td>{{ $exameen->exameen->mobile_no }}</td>
                        <td>{{ $exameen->exameen->email }}</td>
                        <td>{{ $exameen->exameen->pre_addr_ps_id }}</td>
                        {{--<td>--}}
                            @if($exameen->exameen->training_status == 'Pass')
                                <td>
                                    <label class="radio-inline">Pass in Exam</label>
                                    <input type="hidden" name="exam_status[{{ $exameen->exameen->application_no }}]" value="exam">
                                </td>
                                <td></td>
                            @else
                                <td>
                                    <label class="radio-inline">
                                        <input type="radio" class="exameen_pass_status" name="exam_status[{{ $exameen->exameen->application_no }}]" value="Pass" @if($exameen->exameen->training_status == 'Pass')checked @endif>Pass
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="exameen_fail_status" name="exam_status[{{ $exameen->exameen->application_no }}]" value="Fail" @if($exameen->exameen->training_status == 'Fail')checked @endif>Fail
                                    </label>
                                </td>
                                <td><a href="{{ route('exameen_remove_action', [$schedule->id, $exameen->exameen->application_no]) }}">Remove</a></td>
                            @endif

                            {{--<label class="radio-inline">--}}
                                {{--<input type="radio" class="exameen_pass_status" name="exam_status[{{ $exameen->exameen->application_no }}]" value="Pass" @if($exameen->exameen->training_status == 'Pass')checked @endif>Pass--}}
                            {{--</label>--}}
                            {{--<label class="radio-inline">--}}
                                {{--<input type="radio" class="exameen_fail_status" name="exam_status[{{ $exameen->exameen->application_no }}]" value="Fail" @if($exameen->exameen->training_status == 'Fail')checked @endif>Fail--}}
                            {{--</label>--}}
                        {{--</td>--}}
                        {{--<td><a href="{{ route('exameen_remove_action', [$schedule->id, $exameen->exameen->application_no]) }}">Remove</a></td>--}}
                    </tr>
                    @php($i++)
                @endif
            @endforeach

        </tbody>
    </table>
        <div class="col-sm-12" style="  padding: 0px;  padding-left: 20px; margin-top: 20px;">
            <div class="col-sm-12" style="  padding: 0px;  padding-left: 20px; margin-top: 20px; padding-bottom: 10px;">
                <div class="pull-right" style="">
                    <a id="all_exameen_fail" style="background: red; border: red;" href="javascript:void(0)" class="btn btn-primary">All Fail</a>
                </div>
                <div class="pull-right" style="padding-right: 15px; ">
                    <a id="all_exameen_pass" href="javascript:void(0)" class="btn btn-primary">All Pass</a>
                </div>
            </div>
            <div class="pull-right">
                <button type="submit"  class="btn btn-primary">Change Exam Status</button>
            </div>
        </div>
    </form>
</div>
@endsection