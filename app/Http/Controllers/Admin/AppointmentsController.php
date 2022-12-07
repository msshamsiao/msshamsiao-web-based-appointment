<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Clients;
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
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;
use Twilio\Rest\Client;
use Exception;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Appointment::latest();

            if(auth()->user()->roles()->first()->title == 'User'){
                $query = $query->whereHas('client', function($q){
                    $q->where('email', auth()->user()->email);
                });
            }

            $query = $query->get();

            $table = DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('placeholder', '&nbsp;')
            ->addColumn('actions', '&nbsp;')
            ->editColumn('actions', function ($row) {
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
            })
            ->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            })
            ->addColumn('client_name', function ($row) {
                return $row->client['first_name']." ".$row->client['last_name'];
            })
            ->addColumn('lawyer_name', function ($row) {
                return $row->lawyer->lawyer_name;
            })
            ->editColumn('services', function ($row) {
                return sprintf('<span class="badge badge-info">%s</span>', $row->services->name);
            })
            ->addColumn('start_time', function ($row) {
                return date('M j, Y h:m A', strtotime($row->start_time));
            })
            ->addColumn('finish_time', function ($row) {
                return date('M j, Y h:m A', strtotime($row->finish_time));
            })
            ->editColumn('comments', function ($row) {
                return $row->comments;
            })
            ->addColumn('status', function ($row) {
                
                $status = "";
                if($row->status == 'Pending'){
                    $status = '<span class="badge badge-danger">Pending</span>';
                }elseif($row->status == 'Cancelled'){
                    $status = '<span class="badge badge-warning">Cancelled</span>';
                }else{
                    $status = '<span class="badge badge-success">Approved</span>';
                }
                return $status;
            });

            return $table->rawColumns(['actions', 'placeholder', 'client_name', 'lawyer_name', 'services', 'start_time', 'finish_time', 'comments', 'status', 'actions'])
            ->make(true);
 
        }

        return view('admin.appointments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Clients::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lawyers = Lawyer::get();

        $services = Service::get();

        return view('admin.appointments.create', compact('clients','lawyers','services'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        Appointment::create([
            'client_id' => $request->client_id,
            'service_id' => $request->services,
            'lawyer_id' => $request->lawyer_name,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'comments' => $request->comments,
            'status' => 'Pending'
        ]);

        $data = [
            'client_name' => auth()->user()->user_client['first_name']." ".auth()->user()->user_client['last_name'],
            'lawyer_name' => $request->name_lawyer,
            'service' => $request->service_name,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time
        ];

        Mail::to($request->lawyer)->send(new AppointmentMail($data));

        return redirect()->route('admin.appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Clients::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lawyers = Lawyer::get();

        $services = Service::get();

        $appointment->load('client','services');

        return view('admin.appointments.edit', compact('clients','lawyers','services', 'appointment'));
    }

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
       
        if($request->status == 'Approved'){

            $basic  = new \Vonage\Client\Credentials\Basic("cbf88a81", "wegXArswymrv3JvR");
            $client = new \Vonage\Client($basic);

            $client_num = '+639'.substr($request->phone, 2);

            $client->sms()->send(
                new \Vonage\SMS\Message\SMS($client_num, 'PAO Appointment', 'Hello your appointment to PAO is now approved! Thank you!')
            );
        }

        $appointment->update([
            'lawyer_id' => $request->lawyer,
            'service_id' => $request->services,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'comments' => $request->comments,
            'status' => $request->status
        ]);

        return redirect()->route('admin.appointments.index')->with('success','successfully updated!');
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
