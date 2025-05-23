<?php

namespace App\Services\SAP\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\SAP\Contracts\SAPServiceInterface;

/**
 * @method static mixed getSessionId()
 * @method static void refreshSAPSession()
 * @method static void logout()
 * @method static array get(string $endpoint, array $parameters = [], int $pageSize = 1000)
 * @method static mixed getById(string $endpoint, string $id, array $parameters = [])
 * @method static mixed post(string $endpoint, array $data)
 * @method static mixed patch(string $endpoint, string $id, array $data)
 * @method static mixed delete(string $endpoint, string $id)
 * @method static array crossJoin(array $entities, array $parameters = [], int $pageSize = 1000)
 * @method static mixed crossJoinById(array $endpoint, string $id, array $parameters = [])
 * @method static void forgetCache(string $endpoint, array $parameters)
 * 
 * @see \App\Services\SAP\SAPService
 */
class SAP extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SAPServiceInterface::class;
    }
}
