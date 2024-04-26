<?php

namespace App\Repository;

abstract class AbstractRepository
{
    public function getAll(): array
    {
        return $this->model->get()->map(function ($model) {
            return (object)$model->toArray();
        })->all();
    }

    public function store($data): void
    {
        $this->model->create($data);
    }

    public function getById($id): object
    {
        return (object)$this->model->find($id)->toArray();
    }
}
