<?php

namespace App\Helpers\Master;

use App\Models\Master\BookModel;
use App\Repository\CrudInterface;

class BookHelper implements CrudInterface
{

    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        return $this->bookModel->getAll($filter, $itemPerPage, $sort);
    }

    public function getById(int $id): object
    {
        return $this->bookModel->getById(($id));
    }

    public function create(array $payload): array
    {
        // dd($payload);

        $newModel = $this->bookModel->store($payload);

        return ['status' => 'success', 'message' => 'Data berhasil ditambahkan', 'data' => $newModel];
        try {
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update(array $payload, int $id): array
    {
        try {
            $newModel = $this->bookModel->edit($payload, $id);

            return ['status' => 'success', 'message' => 'Data berhasil diubah', 'data' => $newModel];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function delete(int $id): bool
    {
        try {
            $newModel = $this->bookModel->drop($id);
            // $newModel->delete();

            return $newModel;
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
