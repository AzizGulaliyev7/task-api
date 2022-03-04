<?php


namespace App\Repositories\Api\Interfaces;

use App\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;

interface EmployeeRepositoryInterface
{
    public function index();

    public function store(EmployeeCreateRequest $request);

    public function update(EmployeeUpdateRequest $request, Employee $company);
}
