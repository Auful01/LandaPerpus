<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model implements ModelInterface
{
    use HasFactory;

    protected $table = 'm_buku';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_m_kategori_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'keterangan',
        'stok',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'id_m_kategori_buku');
    }

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
        return $model;
    }
}
