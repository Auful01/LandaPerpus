<?php

namespace App\Models\Master;

use App\Models\User\UserModel;
use App\Repository\ModelInterface;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionModel extends Model implements ModelInterface
{
    use HasRelationships, HasFactory;

    protected $table = 'm_transaction';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_transaksi',
        'id_m_buku',
        'id_m_user',
        'jumlah',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_dikembalikan',
        'status',
        'denda'
    ];

    public $timestamps = false;

    public function buku()
    {
        return $this->belongsTo(BookModel::class, 'id_m_buku');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_m_user');
    }

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        $query = $this->newQuery();
        $query->with('buku', 'user');

        return $query->paginate($itemPerPage > 0 ? $itemPerPage : 20)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        // dd($id);
        $coba = $this->findOrFail($id);
        // dd($coba);
        // return $id;
        return $coba;
    }

    public function store(array $payload)
    {
        $payload['kode_transaksi'] = rand(1, 99999);
        $payload['tanggal_peminjaman'] = date('Y-m-d');
        $payload['tanggal_pengembalian'] = date('Y-m-d', strtotime('+' . $payload['day'] . ' days'));
        foreach ($payload['buku'] as $key => $value) {
            $payload['id_m_buku'] = $payload['buku'][$key]['id_m_buku'];
            BookModel::where('id', $payload['id_m_buku'])->decrement('stok', $payload['jumlah']);
            $data = $this->create($payload);
        }
        return $data;
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

    public function pinjam(array $payload)
    {
        $this->create([
            'id_m_buku' => $payload['id_m_buku'],
            'id_m_user' => Auth::user()->id,
            'kode_transaksi' => rand(1, 99999),
            'status' => 'pinjam',
            'tanggal_peminjaman' => date('Y-m-d'),
            'tanggal_pengembalian' => date('Y-m-d', strtotime('+' . $payload['day'] . ' days')),
        ]);
        return $this->create($payload);
    }

    public function getByLogin($id)
    {
        // dd($id);
        // dd(auth()->user()->id);
        $data = $this->with('buku')->where('id_m_user', $id)->get();
        // dd($data);
        return $data;
    }
}
