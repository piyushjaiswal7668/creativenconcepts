<?php

namespace App\Filament\Resources\CompanySettings\Pages;

use App\Filament\Resources\CompanySettings\CompanySettingResource;
use App\Models\CompanySetting;
use Filament\Resources\Pages\EditRecord;

class EditCompanySetting extends EditRecord
{
    protected static string $resource = CompanySettingResource::class;

    public function mount(int | string $record = 1): void
    {
        $record = CompanySetting::firstOrCreate(['id' => 1]);

        $this->record = $record;
        $this->authorizeAccess();
        $this->fillForm();
        $this->previousUrl = url()->previous();
    }
}
