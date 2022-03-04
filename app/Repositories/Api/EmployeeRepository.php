<?php


namespace App\Repositories\Api;

use App\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Repositories\Api\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function index()
    {
        $list = Employee::join('companies', 'employees.company_id', '=', 'companies.id')
            ->select(
                'employees.id', 
                'passport_number', 
                'last_name', 
                'first_name', 
                'middle_name', 
                'position',
                'employees.phone_number', 
                'employees.address', 
                'employees.created_at',
                'companies.name as company'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return $list;
    }

    public function store(EmployeeCreateRequest $request)
    {
        $employee = Employee::create([
            'company_id'            => $request['company_id'],
            'passport_number'       => $request['passport_number'],
            'last_name'             => $request['last_name'],
            'first_name'            => $request['first_name'],
            'middle_name'           => $request['middle_name'],
            'position'              => $request['position'],
            'phone_number'          => $request['phone_number'],
            'address'               => $request['address']
        ]);

        return $employee;
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee->update([
            'company_id'            => $request['company_id'],
            'passport_number'       => $request['passport_number'],
            'last_name'             => $request['last_name'],
            'first_name'            => $request['first_name'],
            'middle_name'           => $request['middle_name'],
            'position'              => $request['position'],
            'phone_number'          => $request['phone_number'],
            'address'               => $request['address']
        ]);

        return $employee;
    }
}
