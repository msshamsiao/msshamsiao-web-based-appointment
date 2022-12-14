@extends('layouts.admin')
@section('content')
@can('appointment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
           @can('appointment_create')
                <a class="btn btn-success" href="{{ route("admin.appointments.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.appointment.title_singular') }}
                </a>
           @endcan
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.appointment.title_singular') }} {{ trans('global.list') }}
    </div>
    
    <br/>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <h4 class="alert-heading">Success!</h4>
            <hr>
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Appointment">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Layyer Name</th>
                    <th>Service</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Comments </th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('appointment_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.appointments.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')
                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.appointments.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'client_name', name: 'client.name' },
                { data: 'lawyer_name', name: 'lawyer_name' },
                { data: 'services', name: 'services.' },
                { data: 'start_time', name: 'start_time' },
                { data: 'finish_time', name: 'finish_time' },
                { data: 'comments', name: 'comments' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: '{{ trans('global.actions') }}' },
                { data: 'placeholder', name: 'placeholder' },
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        };
        $('.datatable-Appointment').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        });

</script>
@endsection