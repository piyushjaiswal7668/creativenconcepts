<?php

namespace App\Filament\Resources\CompanySettings;

use App\Filament\Resources\CompanySettings\Pages\EditCompanySetting;
use App\Filament\Resources\Concerns\ChecksPermissions;
use App\Models\CompanySetting;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;

class CompanySettingResource extends Resource
{
    use ChecksPermissions;

    protected static ?string $model = CompanySetting::class;
    protected static function permissionResource(): string
    {
        return 'company_setting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            SpatieMediaLibraryFileUpload::make('logo')
                ->collection('logo')
                ->image(),
            Textarea::make('address')->columnSpanFull(),
            TextInput::make('mobile')->maxLength(50),
            TextInput::make('email')->email()->maxLength(255),
            TextInput::make('whatsapp')->maxLength(50),
            TextInput::make('google_maps')->label('Google Maps Location')->maxLength(255),
            KeyValue::make('social_links_json')->label('Social Links'),
            Toggle::make('is_active'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'edit' => EditCompanySetting::route('/'),
        ];
    }
}
