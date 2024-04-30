<?php

namespace App\Repository\Company;

use App\Models\Company;
use App\Repository\AbstractRepository;
use App\Repository\Interfaces\BaseRepositoryInterface;

class CompanyRepository extends AbstractRepository implements BaseRepositoryInterface
{
    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }
}
