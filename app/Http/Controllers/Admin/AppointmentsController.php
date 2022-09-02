<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Client;
use App\Employee;
use App\Lawyer;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Appointment::select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $crudRoutePart = 'appointments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('client_name', function ($row) {
                return $row->client_id;
            });

            $table->addColumn('lawyer_name', function ($row) {
                return $row->lawyer->lawyer_name;
            });

            $table->editColumn('services', function ($row) {
                return sprintf('<span class="badge badge-info">%s</span>', $row->services->name);
            });

            $table->addColumn('start_time', function ($row) {
                return date('M j, Y h:m A', strtotime($row->start_time));
            });

            $table->addColumn('finish_time', function ($row) {
                return date('M j, Y h:m A', strtotime($row->finish_time));
            });

            $table->editColumn('comments', function ($row) {
                return $row->comments;
            });
            
            $table->addColumn('status', function ($row) {
                
                $status = "";
                if($row->status == 'Pending'){
                    $status = '<span class="badge badge-danger">Pending</span>';
                }else{
                    $status = '<span class="badge badge-success">Approved</span>';
                }
                return $status;
            });

            $table->rawColumns(['actions', 'placeholder', 'client_name', 'lawyer_name', 'services', 'start_time', 'finish_time', 'comments', 'status', 'actions']);

            return $table->make(true);
        }

        return view('admin.appointments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lawyers = Lawyer::get();

        $services = Service::get();

        return view('admin.appointments.create', compact('clients','lawyers','services'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        Appointment::create([
            'client_id' => $request->lawyer,
            'service_id' => $request->services,
            'lawyer_id' => $request->lawyer,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'comments' => $request->comments,
            'status' => 'Pending'
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::all()->pluck('name', 'id');

        $appointment->load('client', 'employee', 'services');

        return view('admin.appointments.edit', compact('clients', 'employees', 'services', 'appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->load('client', 'employee', 'services');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
