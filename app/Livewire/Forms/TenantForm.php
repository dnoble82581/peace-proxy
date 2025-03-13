<?php

namespace App\Livewire\Forms;

use App\Models\Tenant;
use Livewire\Form;

class TenantForm extends Form
{
    public ?Tenant $tenant;

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

    public $logo;

    public string $tax_exempt = '';

    public string $tax_id = '';

    public string $extra_billing_information = '';

    public function mount(?Tenant $tenant = null): void
    {
        if ($tenant) {
            $this->tenant = $tenant;
            $this->setForm($tenant);
        }
    }

    public function setForm(Tenant $tenant): void
    {
        $this->tenant_name = $tenant->tenant_name;
        $this->tenant_email = $tenant->tenant_email;
        $this->primary_phone = $tenant->primary_phone;
        $this->secondary_phone = $tenant->secondary_phone;
        $this->address_line1 = $tenant->address_line1;
        $this->address_line2 = $tenant->address_line2;
        $this->address_city = $tenant->address_city;
        $this->address_state = $tenant->address_state;
        $this->address_postal_code = $tenant->address_postal_code;
        $this->address_country = $tenant->address_country;
        $this->tenant_logo = $tenant->tenant_logo;
        $this->tax_exempt = $tenant->tax_exempt;
        $this->tax_id = $tenant->tax_id;
        $this->extra_billing_information = $tenant->extra_billing_information;
    }

    public function create()
    {
        $this->validate([
            'tenant_name' => 'required',
            'tenant_email' => 'required|email',
            'primary_phone' => 'required|nullable',
            'secondary_phone' => 'nullable',
            'logo' => 'required|image|max:1024',
            'tenant_logo' => 'nullable|string',
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

        if ($this->logo) {
            $tenantData['tenant_logo'] = $this->saveTenantLogo($this->logo);
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

    private function saveTenantLogo($logo)
    {
        return $logo->store('logos', 's3-public');
    }
}
