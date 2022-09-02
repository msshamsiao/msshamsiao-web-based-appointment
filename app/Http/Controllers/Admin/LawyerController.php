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
            $query = Lawyer::select(sprintf('%s.*', (new Lawyer())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('lawyer_name', function ($row) {
                return $row->lawyer_name;
            });
            $table->addColumn('contact_number', function ($row) {
                return $row->phone;
            });
            $table->addColumn('email', function ($row) {
                return $row->email;
            });
            $table->addColumn('status', function ($row) {
                return $row->email;
            });
            $table->editColumn('actions', function ($row) {
                $viewGate      = 'lawyer_show';
                $editGate      = 'lawyer_edit';
                $deleteGate    = 'lawyer_delete';
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'lawyer_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $input = $request->all();
        Lawyer::create($input);

        return redirect()->route('admin.lawyer.index')->with('success','Successfully created!');
    }
}
