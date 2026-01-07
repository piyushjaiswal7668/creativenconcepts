<?php

namespace App\Filament\Resources\TeamMembers;

use App\Filament\Resources\Concerns\ChecksPermissions;
use App\Filament\Resources\TeamMembers\Pages\CreateTeamMember;
use App\Filament\Resources\TeamMembers\Pages\EditTeamMember;
use App\Filament\Resources\TeamMembers\Pages\ListTeamMembers;
use App\Models\TeamMember;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    use ChecksPermissions;

    protected static ?string $model = TeamMember::class;
    protected static function permissionResource(): string
    {
        return 'team_member';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('role')->maxLength(255),
            Textarea::make('bio')->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('photo')
                ->collection('photo')
                ->image(),
            TextInput::make('sort_order')->numeric(),
            Toggle::make('is_active')->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')->collection('photo'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('role')->searchable(),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_active')->label('Status'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeamMembers::route('/'),
            'create' => CreateTeamMember::route('/create'),
            'edit' => EditTeamMember::route('/{record}/edit'),
        ];
    }
}
