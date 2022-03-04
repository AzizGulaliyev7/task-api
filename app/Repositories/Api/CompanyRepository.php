<?php


namespace App\Repositories\Api;

use App\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Repositories\Api\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function index()
    {
        $list = Company::select(
                'id',
                'name', 
                'ceo_name', 
                'address', 
                'email', 
                'web_site', 
                'phone_number',
                'created_at', 
                'updated_at'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return  $list;
    }

    public function getUserCompany()
    {
        $company = Company::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();

        return  $company;
    }

    public function store(CompanyCreateRequest $request)
    {
        $company = Company::create([
            'user_id'       => Auth::user()->id,
            'name'          => $request['name'],
            'ceo_name'      => $request['ceo_name'],
            'address'       => $request['address'],
            'email'         => $request['email'],
            'web_site'      => $request['web_site'],
            'phone_number'  => $request['phone_number'],
        ]);

        return $company;
    }

    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company->update([
            'name'          => $request['name'],
            'ceo_name'      => $request['ceo_name'],
            'address'       => $request['address'],
            'email'         => $request['email'],
            'web_site'      => $request['web_site'],
            'phone_number'  => $request['phone_number'],
        ]);

        return $company;
    }
}
