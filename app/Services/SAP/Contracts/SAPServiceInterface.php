<?php

namespace App\Services\SAP\Contracts;

interface SAPServiceInterface
{
    /**
     * Login ke SAP dan mendapatkan session ID
     *
     * @return mixed
     */
    public function getSessionId();

    /**
     * Refresh session SAP
     */
    public function refreshSAPSession();

    /**
     * Logout dari SAP
     */
    public function logout();

    /**
     * Mendapatkan data dari SAP
     *
     * @param string $endpoint
     * @param array $parameters
     * @param int $pageSize
     * @return array
     */
    public function get(string $endpoint, array $parameters = [], int $pageSize = 1000): array;

    /**
     * Mendapatkan data berdasarkan ID
     *
     * @param string $endpoint
     * @param string $id
     * @param array $parameters
     * @return mixed
     */
    public function getById(string $endpoint, string $id, array $parameters = []);

    /**
     * Membuat data baru
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function post(string $endpoint, array $data);

    /**
     * Memperbarui data
     *
     * @param string $endpoint
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function patch(string $endpoint, string $id, array $data);

    /**
     * Menghapus data
     *
     * @param string $endpoint
     * @param string $id
     * @return mixed
     */
    public function delete(string $endpoint, string $id);

    /**
     * Melakukan cross join pada entity
     *
     * @param array $entities
     * @param array $parameters
     * @param int $pageSize
     * @return array
     */
    public function crossJoin(array $entities, array $parameters = [], int $pageSize = 1000);

    /**
     * Melakukan cross join berdasarkan ID
     *
     * @param array $endpoint
     * @param string $id
     * @param array $parameters
     * @return mixed
     */
    public function crossJoinById(array $endpoint, string $id, array $parameters = []);

    /**
     * Menghapus cache
     *
     * @param string $endpoint
     * @param array $parameters
     */
    public function forgetCache($endpoint, $parameters);
}
