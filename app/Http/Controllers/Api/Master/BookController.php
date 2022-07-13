<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Master\BookHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\CreateRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Item\DetailResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $book;

    public function __construct()
    {
        $this->book = new BookHelper();
    }

    public function index(Request $request)
    {
        $filter = ['nama' => $request->nama ?? ''];
        $listBook = $this->book->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new BookCollection($listBook));
    }

    public function store(CreateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $dataInput = $request->all();
        $dataItem = $this->book->create($dataInput);

        if (!$dataItem['status']) {
            return response()->failed($dataItem['error'], 422);
        }

        return response()->success([], 'Data book berhasil disimpan');
    }

    public function show($id)
    {
        $dataItem = $this->book->getById($id);
        return $dataItem;
        // dd($dataItem);
        // if (!$dataItem['status']) {
        //     return response()->failed($dataItem['error'], 422);
        // }

        // return response()->success(new DetailResource($dataItem));
    }

    public function update(UpdateRequest $request, $id)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $dataInput = $request->only(['nama', 'deskripsi', 'harga', 'foto', 'is_available', 'kategori', 'detail']);
        $dataItem = $this->book->update($dataInput, $id);

        if (!$dataItem['status']) {
            return response()->failed($dataItem['error'], 422);
        }

        return response()->success([], 'Data book berhasil diubah');
    }

    public function destroy($id)
    {
        $dataItem = $this->book->delete($id);

        if (!$dataItem['status']) {
            return response()->failed($dataItem['error'], 422);
        }

        return response()->success([], 'Data book berhasil dihapus');
    }
}
