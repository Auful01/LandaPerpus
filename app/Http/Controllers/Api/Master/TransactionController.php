<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Master\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Master\BookModel;
use App\Models\Master\TransactionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new TransactionHelper();
    }

    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $listTransaction = $this->transaction->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new TransactionCollection($listTransaction));
    }

    public function store(CreateRequest $request)
    {
        // dd($request->all());
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Transaction/TransactionRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        // $dataInput = $request->only(['nama', 'email', 'is_verified']);
        $dataInput = $request->only(['buku', 'id_m_user', 'jumlah', 'status', 'day']);
        // dd($dataInput);
        // dd($dataInput);
        $dataCust = $this->transaction->create($dataInput);

        // if (!$dataCust['status']) {
        //     return response()->failed($dataCust['error'], 422);
        // }

        return response()->success($dataCust, 'Data transaction berhasil disimpan');
    }

    public function show($id)
    {
        $dataCust = $this->transaction->getById($id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success(new TransactionResource($dataCust));
    }

    public function update(UpdateRequest $request, $id)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Transaction/TransactionRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $dataInput = $request->only(['nama', 'email', 'is_verified']);
        $dataCust = $this->transaction->update($request->all(), $id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data transaction berhasil diubah');
    }

    public function destroy($id)
    {
        $dataCust = $this->transaction->delete($id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data transaction berhasil dihapus');
    }

    public function pinjam(Request $request)
    {
        $dataInput = $request->only(['id_m_buku', 'id_m_user', 'jumlah', 'status', 'day']);
        $dataCust = $this->transaction->pinjam($dataInput);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data transaction berhasil dipinjam');
    }

    public function kembali(UpdateRequest $request)
    {
        // dd($request['id']);
        try {
            $transaction = TransactionModel::with('buku')->where('id', $request['id'])->first();
            // dd($transaction);
            $book =  BookModel::where('id', $transaction['id_m_buku'])->first();
            // return $request->id;
            // dd($transaction->jumlah);
            // return $transaction;
            // Book::where('id', $request->id)->update([
            //     'status' => 'tersedia',
            // ]);
            // dd($book->stok);

            $start = Carbon::now();
            $end = new Carbon($transaction->tanggal_pengembalian);

            $diff = $end->diffInDays($start);
            // dd($diff);
            if ($diff < 0) {
                $denda = $diff * 1000;
                BookModel::where('id', $transaction['id_m_buku'])->update([
                    'stok' => intval($book->stok) + intval($transaction->jumlah),
                ]);
                TransactionModel::where('id_m_buku', $request->id)->update([
                    'tanggal_dikembalikan' => Carbon::now(),
                    'status' => 'kembali',
                    'denda' => $denda,
                ]);
                return response()->json([
                    'status' => 'success',
                    'data' => 'Anda terkena Denda Sebesar:' . $denda,
                ]);
            } else {
                BookModel::where('id', $transaction['id_m_buku'])->update([
                    'stok' => intval($book->stok) + intval($transaction->jumlah),
                ]);
                TransactionModel::where('id', $request->id)->update([
                    'tanggal_dikembalikan' => Carbon::now(),
                    'status' => 'kembali',
                ]);
                return response()->json([
                    'status' => 'success',
                    'data' => 'Terima Kasih Mengembalikan Tepat Waktu',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function getByLogin(Request $request)
    {

        // dd($request->id);
        $dataCust = $this->transaction->getByLogin($request->id);
        // if (!$dataCust['status']) {
        //     return response()->failed($dataCust['error'], 422);
        // }

        return response()->success(new TransactionResource($dataCust));
    }
}
