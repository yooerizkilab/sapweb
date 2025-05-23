<?php

namespace App\Services\SAP\Contracts;

interface SAPRepositoryInterface
{
    /**
     * Mendapatkan semua data
     *
     * @param array $parameters
     * @return array
     */
    public function getAll(array $parameters = []): array;

    /**
     * Mendapatkan data berdasarkan ID
     *
     * @param string $id
     * @param array $parameters
     * @return mixed
     */
    public function find(string $id, array $parameters = []);

    /**
     * Membuat data baru
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Memperbarui data
     *
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data);

    /**
     * Menghapus data
     *
     * @param string $id
     * @return mixed
     */
    public function delete(string $id);
}
