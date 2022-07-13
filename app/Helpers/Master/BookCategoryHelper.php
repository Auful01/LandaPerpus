<?php

namespace App\Helpers\Master;

use App\Models\Master\BookCategoryModel;
use App\Repository\CrudInterface;

class BookCategoryHelper implements CrudInterface
{

    protected $bookCategoryModel;

    public function __construct()
    {
        $this->bookCategoryModel = new BookCategoryModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        return $this->bookCategoryModel->getAll($filter, $itemPerPage, $sort);
    }

    public function getById(int $id): object
    {
        return $this->bookCategoryModel->getById(($id));
    }

    public function create(array $payload): array
    {
        try {
            $newModel = $this->bookCategoryModel->store($payload);

            return ['status' => 'success', 'message' => 'Data berhasil ditambahkan', 'data' => $newModel];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update(array $payload, int $id): array
    {
        try {
            $newModel = $this->bookCategoryModel->edit($payload, $id);

            return ['status' => 'success', 'message' => 'Data berhasil diubah', 'data' => $newModel];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $newModel = $this->bookCategoryModel->drop($id);
            // $newModel->delete();

            return true;
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
