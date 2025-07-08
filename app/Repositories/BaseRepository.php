<?php
namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, Model>
     */
    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    /**
     * @return Model
     */
    public function find(int $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    /**
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->model->newQuery()->findOrFail($id);
        $record->update($data);
        return $record;
    }

    /**
     * @return bool
     */
    public function delete(int $id): ?bool
    {
        $record = $this->model->newQuery()->findOrFail($id);
        return $record->delete();
    }
}