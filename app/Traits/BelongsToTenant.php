<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Scopes\TenantScope;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(/**
         * @throws ContainerExceptionInterface
         * @throws NotFoundExceptionInterface
         */
            function ($model) {
                if (session()->has('tenant_id')) {
                    $model->tenant_id = session()->get('tenant_id');
                }
            });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
