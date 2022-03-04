<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Exceptions\ApiModelNotFoundException;
use App\Exceptions\CanNotBeDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Repositories\Api\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    protected $model;
    private $companyRepository;

    public function __construct(Company $model, CompanyRepositoryInterface $companyRepository)
    {
        $this->middleware('auth:api');
        $this->middleware('rolecompany')->only('store');
        $this->model = $model;
        $this->companyRepository = $companyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->companyRepository->index();

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'companies' => $companies,
                ]
            ]
        ]);
    }


    /**
     * Display a listing of the light version of resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserCompany()
    {
        $company = $this->companyRepository->getUserCompany();

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'company' => $company,
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
    public function store(CompanyCreateRequest $request)
    {
        $company = $this->companyRepository->store($request);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => 'Company is successfuly created',
                'data' => [
                    'company' => $company,
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
        if (!$company = Company::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega Korxona tizimda mavjud emas.");
        }
        
        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'company' => $company,
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
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company = $this->companyRepository->update($request, $company);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => "Company is successfuly updated",
                'data' => [
                    'company' => $company,
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
        if (!$company = Company::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega Korxona tizimda mavjud emas.");
        }

        $user = Auth::user();
        if (($user->role == 'company') && !Company::where('id', $id)->where('user_id', $user->id)->exists()) {
            throw new CanNotBeDeleted("Company rolidagi foydalanuvchi oziga tegishli bolmaga korxonani ochirishi mumkin emas!");
        }

        if (DB::table('employees')->whereNull('deleted_at')->where('company_id', $id)->exists()) {
            throw new CanNotBeDeleted("Korxonani ochirib bolmaydi. Korxonaga tegishli xodimlar mavjud!");
        }

        $deleted = $company->delete();

        return response()->json([
            'result' => [
                'success' => true,
                'message' => "Company is successfuly deleted",
                'data' => [
                    'deleted' => $deleted,
                ]
            ]
        ]);
    }
}
