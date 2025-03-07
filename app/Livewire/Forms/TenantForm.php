<?php

namespace App\Livewire\Forms;

use App\Models\Tenant;
use Livewire\Form;

class TenantForm extends Form
{
    public string $tenant_name = '';

    public string $tenant_email = '';

    public string $primary_phone = '';

    public string $secondary_phone = '';

    public string $address_line1 = '';

    public string $address_line2 = '';

    public string $address_city = '';

    public string $address_state = '';

    public string $address_postal_code = '';

    public string $address_country = 'US';

    public string $tenant_logo = '';

    public string $tax_exempt = '';

    public string $tax_id = '';

    public string $extra_billing_information = '';

    public function create()
    {
        $this->validate([
            'tenant_name' => 'required',
            'tenant_email' => 'required|email',
            'primary_phone' => 'required|nullable',
            'secondary_phone' => 'nullable',
            'tenant_logo' => 'nullable|image|max:1024',
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'address_city' => 'required',
            'address_state' => 'required',
            'address_postal_code' => 'required',
            'address_country' => 'required',
            'tax_exempt' => 'nullable',
            'tax_id' => 'nullable|unique:tenants,tax_id',
            'extra_billing_information' => 'nullable',
        ]);

        $tenantData = $this->collectTenantData();

        if ($this->tenant_logo) {
            $tenantData['tenant_logo'] = $this->saveTenantLogo();
        }

        return Tenant::create($tenantData);
    }

    private function collectTenantData(): array
    {
        return [
            'tenant_name' => $this->tenant_name,
            'tenant_email' => $this->tenant_email,
            'primary_phone' => $this->primary_phone,
            'secondary_phone' => $this->secondary_phone,
            'tenant_logo' => $this->tenant_logo,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'address_city' => $this->address_city,
            'address_state' => $this->address_state,
            'address_postal_code' => $this->address_postal_code,
            'address_country' => $this->address_country,
            'tax_exempt' => $this->tax_exempt,
            'tax_id' => $this->tax_id,
            'extra_billing_information' => $this->extra_billing_information,
        ];

    }

    private function saveTenantLogo()
    {
        return $this->tenant_logo->store($this->tenant_name.'/logos/'.$this->tenant_name, 's3-public');
    }
}
