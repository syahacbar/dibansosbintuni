<?php

namespace App\Services\MasterData;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class MasterDataService
{
    /**
     * @return class-string<Model>
     */
    abstract protected function modelClass(): string;

    /**
     * @return list<string>
     */
    protected function searchableColumns(): array
    {
        return ['kode', 'nama'];
    }

    /**
     * @return list<string>
     */
    protected function relations(): array
    {
        return [];
    }

    public function paginate(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()
            ->when($search, function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    foreach ($this->searchableColumns() as $column) {
                        if (Str::contains($column, '.')) {
                            [$relation, $relationColumn] = explode('.', $column, 2);

                            $query->orWhereRelation($relation, $relationColumn, 'like', "%{$search}%");

                            continue;
                        }

                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Model
    {
        $modelClass = $this->modelClass();

        return $modelClass::create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->refresh();
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }

    protected function query(): Builder
    {
        $modelClass = $this->modelClass();

        return $modelClass::query()->with($this->relations());
    }
}
