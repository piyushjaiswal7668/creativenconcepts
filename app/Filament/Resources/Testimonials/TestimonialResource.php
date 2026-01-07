<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Concerns\ChecksPermissions;
use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
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

class TestimonialResource extends Resource
{
    use ChecksPermissions;

    protected static ?string $model = Testimonial::class;

    protected static function permissionResource(): string
    {
        return 'testimonial';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('role')->maxLength(255),
            Textarea::make('content')->required()->columnSpanFull(),
            TextInput::make('rating')->numeric()->minValue(1)->maxValue(5),
            SpatieMediaLibraryFileUpload::make('avatar')
                ->collection('avatar')
                ->image(),
            TextInput::make('sort_order')->numeric(),
            Toggle::make('status')->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')->collection('avatar'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('role')->searchable(),
                TextColumn::make('rating')->sortable(),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('status')->label('Status'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
