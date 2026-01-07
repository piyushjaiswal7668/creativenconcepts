<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Concerns\ChecksPermissions;
use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
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

class ProjectResource extends Resource
{
    use ChecksPermissions;

    protected static ?string $model = Project::class;
    protected static function permissionResource(): string
    {
        return 'project';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255),
            TextInput::make('location')->maxLength(255),
            TextInput::make('year')->maxLength(10),
            Textarea::make('description')->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('gallery')
                ->collection('gallery')
                ->image()
                ->multiple(),
            TextInput::make('sort_order')->numeric(),
            Toggle::make('is_active')->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('gallery')->collection('gallery'),
                TextColumn::make('title')->searchable(),
                TextColumn::make('location')->searchable(),
                TextColumn::make('year')->sortable(),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_active')->label('Status'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
