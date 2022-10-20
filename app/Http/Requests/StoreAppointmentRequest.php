<?php

namespace App\Http\Requests;

use App\Appointment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'lawyer_id' => 'required',

            'start_time'  => 'required|unique:appointments',
                [
                    'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                ],

            'finish_time' => 'required',
                [
                    'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                ],

            'service_id' => 'required',
        ];
    }

    public function messages()
    {
        return [

            'start_time.required' => 'Start Time is required',
            'finish.required' => 'Finish Time is required',

            'start_time.unique' => 'Start Time is not avaiable! Please choose another time.' 
        ];
    }
}
