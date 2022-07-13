<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Master\BookCategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCategory\CreateRequest;
use App\Http\Requests\BookCategory\UpdateRequest;
use App\Http\Resources\BookCategory\BookCategoryCollection;
use App\Http\Resources\BookCategory\BookCategoryResource;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    private $bookCategory;

    public function __construct()
    {
        // dd('tes');
        $this->bookCategory = new BookCategoryHelper();
    }

    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $listBookCategory = $this->bookCategory->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new BookCategoryCollection($listBookCategory));
    }

    public function store(CreateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/Transaction/TransactionRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $dataInput = $request->only(['nama']);
        $dataCust = $this->bookCategory->create($dataInput);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data book category berhasil disimpan');
    }

    public function show($id)
    {
        $dataCust = $this->bookCategory->getById($id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success(new BookCategoryResource($dataCust['data']));
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

        $dataInput = $request->only(['nama']);
        $dataCust = $this->bookCategory->update($dataInput, $id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data book category berhasil diubah');
    }

    public function destroy($id)
    {
        $dataCust = $this->bookCategory->delete($id);

        if (!$dataCust['status']) {
            return response()->failed($dataCust['error'], 422);
        }

        return response()->success([], 'Data book category berhasil dihapus');
    }
}
