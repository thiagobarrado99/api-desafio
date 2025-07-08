<?php
namespace App\Interfaces;

interface RepositoryInterface
{
    public function all(): mixed;

    public function find(int $id): mixed;

    /**
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * @param int $id
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed;

    public function delete(int $id): ?bool;
}