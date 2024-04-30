<?php

namespace App\Repository\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll(): array;

    public function getById($id): object;

    public function store($data): void;

}
