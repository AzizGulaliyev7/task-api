<?php


namespace App\Repositories\Api\Interfaces;

use App\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;

interface CompanyRepositoryInterface
{
    public function index();

    public function getUserCompany();

    public function store(CompanyCreateRequest $request);

    public function update(CompanyUpdateRequest $request, Company $company);
}
