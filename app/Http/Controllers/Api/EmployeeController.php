<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Exceptions\ApiModelNotFoundException;
use App\Exceptions\CanNotBeDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Repositories\Api\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    protected $model;
    private $employeeRepository;

    public function __construct(Employee $model, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->middleware('auth:api');
        $this->middleware('rolecheck')->only(['store', 'update', 'destroy']);
        $this->model = $model;
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeRepository->index();

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'employees' => $employees,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeCreateRequest $request)
    {
        $employee = $this->employeeRepository->store($request);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => 'Employee is successfuly created',
                'data' => [
                    'employee' => $employee,
                ]
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$employee = Employee::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega Xodim tizimda mavjud emas");
        }

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'employee' => $employee,
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee = $this->employeeRepository->update($request, $employee);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => "Employee is successfuly updated",
                'data' => [
                    'employee' => $employee,
                ]
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$employee = Employee::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega Xodim tizimda mavjud emas");
        }

        $user = Auth::user();
        $exists = Employee::where('id', $id)->whereHas('company', function (Builder $query) use($user) {
                $query->where('user_id', $user->id);
            })->exists();
        if (($user->role == 'company') && !$exists) {
            throw new CanNotBeDeleted("Company rolidagi foydalanuvchi oziga tegishli bolmaga xodimni ochirishi mumkin emas!");
        }

        $deleted = $employee->delete();

        return response()->json([
            'result' => [
                'success' => true,
                'message' => "Employee is successfuly deleted",
                'data' => [
                    'deleted' => $deleted,
                ]
            ]
        ]);
    }
}
