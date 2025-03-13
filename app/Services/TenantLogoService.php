<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Storage;

class TenantLogoService
{
    public function getLogoUrl(Tenant $tenant): string
    {
        if ($tenant->tenant_logo) {
            return Storage::disk('s3-public')->url($tenant->tenant_logo);
        }

        return 'https://api.dicebear.com/9.x/initials/svg?seed='.$tenant->tenant_name;
    }
}
