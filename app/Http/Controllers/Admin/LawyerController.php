<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Client;
use App\Lawyer;
use Gate;

use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LawyerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Lawyer::with(['client', 'employee', 'services'])->select(sprintf('%s.*', (new Lawyer())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('lawyer_name', function ($row) {
                return $row->client ? $row->client->name : '';
            });
            $table->addColumn('contact_number', function ($row) {
                return $row->client ? $row->client->name : '';
            });
            $table->addColumn('email', function ($row) {
                return $row->client ? $row->client->name : '';
            });
            $table->addColumn('status', function ($row) {
                return $row->client ? $row->client->name : '';
            });
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

            $table->rawColumns(['actions', 'placeholder', 'lawyer_name', 'contact_number', 'email', 'status']);

            return $table->make(true);
        }

        return view('admin.lawyer.index');
    }

    public function create()
    {
        return view('admin.lawyer.create');
    }

    public function store()
    {

    }
}
