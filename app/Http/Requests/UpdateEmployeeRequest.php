<?php

namespace App\Http\Requests;

use App\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('lawyer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'lawyer_name'       => [
                'required',
            ],
            'services.*' => [
                'integer',
            ],
            'services'   => [
                'array',
            ],
        ];
    }
}
