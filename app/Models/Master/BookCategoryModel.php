<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategoryModel extends Model implements ModelInterface
{
    use HasFactory;

    protected $table = 'm_kategori_buku';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
    ];

    public $timestamps = false;

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        $query = $this->query();

        return $query->paginate(5)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        return $this->findOrFail($id);
    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function edit(array $payload, int $id)
    {
        $model = $this->findOrFail($id);
        $model->update($payload);
        return $model;
    }

    public function drop(int $id)
    {
        $model = $this->findOrFail($id);
        $model->delete();
    }
}
