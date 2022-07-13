<?php

namespace App\Helpers\Master;

use App\Models\Master\TransactionModel;
use App\Repository\CrudInterface;

class TransactionHelper  implements CrudInterface
{

    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        return $this->transactionModel->getAll($filter, $itemPerPage, $sort);
    }

    public function getById(int $id): object
    {
        return $this->transactionModel->getById(($id));
    }

    public function create(array $payload): array
    {
        try {
            $newModel = $this->transactionModel->store($payload);

            return ['status' => 'success', 'message' => 'Data berhasil ditambahkan', 'data' => $newModel];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update(array $payload, int $id): array
    {
        try {
            $newModel = $this->transactionModel->edit($payload, $id);

            return ['status' => 'success', 'message' => 'Data berhasil diubah', 'data' => $newModel];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $newModel = $this->transactionModel->drop($id);
            // $newModel->delete();

            return $newModel;
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function pinjam(array $payload): array
    {
        try {
            $update = $this->transactionModel->pinjam($payload);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getByLogin($id)
    {
        // dd($id);
        try {
            $update = $this->transactionModel->getByLogin($id);

            return ['status' => 'success', 'message' => 'Data ditemukan', 'data' => $update];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
