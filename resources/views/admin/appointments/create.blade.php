@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.appointment.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.appointments.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input hidden name="client_id" value="{{ auth()->user()->user_client['id'] }}"> 

            <div class="form-group">
                <label for="lawyer">Lawyer <span style="color: red; font-weight:bold">*</span></label>
                <select name="lawyer_name" id="lawyer_name" class="form-control select2">
                    <option disabled selected hidden>Choose Lawyer</option>
                    @foreach($lawyers as $lawyer)
                        <option value="{{ $lawyer->id }}" data-id="{{ $lawyer->email }}" data-name="{{ $lawyer->lawyer_name }}">{{ $lawyer->lawyer_name }}</option>
                    @endforeach
                </select>
                <input type="text" name="lawyer" id="lawyer" value="">
                <input type="text" name="name_lawyer" id="name_lawyer" value="">
            </div>
            <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                <label for="services">Services <span style="color: red; font-weight:bold">*</span>
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                </label>
                <select name="services" id="services" class="form-control select2">
                    <option disabled selected hidden>Choose Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-id="{{ $service->name }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <input hidden name="service_name" id="service_name" value="">
                @if($errors->has('services'))
                    <em class="invalid-feedback">
                        {{ $errors->first('services') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.appointment.fields.services_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                <label for="start_time">Start Time <span style="color: red; font-weight:bold">*</span></label>
                <input type="text" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($appointment) ? $appointment->start_time : '') }}" required>
                @if($errors->has('start_time'))
                    <em class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.appointment.fields.start_time_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('finish_time') ? 'has-error' : '' }}">
                <label for="finish_time">Finish Time <span style="color: red; font-weight:bold">*</span></label>
                <input type="text" id="finish_time" name="finish_time" class="form-control datetime" value="{{ old('finish_time', isset($appointment) ? $appointment->finish_time : '') }}" required>
                @if($errors->has('finish_time'))
                    <em class="invalid-feedback">
                        {{ $errors->first('finish_time') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.appointment.fields.finish_time_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('comments') ? 'has-error' : '' }}">
                <label for="comments">Comments <span style="color:lightblue; font-weight:bold">(optional)</span></label>
                <textarea id="comments" name="comments" class="form-control ">{{ old('comments', isset($appointment) ? $appointment->comments : '') }}</textarea>
                @if($errors->has('comments'))
                    <em class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.appointment.fields.comments_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                <a class="btn btn-info" href="{{ route('admin.appointments.index') }}">Back</a>
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function(){
        $('#services').change(function() {
            $('#service_name').val($('#services option:selected').data('id'));
        }).trigger('change');

        $('#lawyer_name').change(function() {
            $('#lawyer').val($('#lawyer_name option:selected').data('id'));
        }).trigger('change');

        $('#lawyer_name').change(function() {
            $('#name_lawyer').val($('#lawyer_name option:selected').data('name'));
        }).trigger('change');
    });
</script>
@endsection