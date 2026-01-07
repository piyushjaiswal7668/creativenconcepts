<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('source_page')
                    ->default(null),
                TextInput::make('product_id')
                    ->numeric()
                    ->default(null),
                Select::make('property_type')
                    ->options(PropertyType::class)
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->required()
                    ->maxLength(50),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(LeadStatus::class)
                    ->default(LeadStatus::New->value)
                    ->required()
                    ->disabled(fn () => ! auth()->user()?->can('update_lead')),
                Textarea::make('utm_json')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('ip')
                    ->maxLength(45)
                    ->default(null),
                TextInput::make('user_agent')
                    ->maxLength(500)
                    ->default(null),
            ]);
    }
}
