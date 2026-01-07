<?php

declare(strict_types=1);

namespace App\Filament\Resources\Roles;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Pages\ViewRole;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use BezhanSalleh\PluginEssentials\Concerns\Resource as Essentials;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Toggle;
class RoleResource extends Resource
{
    use Essentials\BelongsToParent;
    use Essentials\BelongsToTenant;
    use Essentials\HasLabels;
    use Essentials\HasNavigation;
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->unique(
                                        ignoreRecord: true, /** @phpstan-ignore-next-line */
                                        modifyRuleUsing: fn (Unique $rule): Unique => Utils::isTenancyEnabled() ? $rule->where(Utils::getTenantModelForeignKey(), Filament::getTenant()?->id) : $rule
                                    )
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(Utils::getFilamentAuthGuard())
                                    ->nullable()
                                    ->maxLength(255),

                                Select::make(config('permission.column_names.team_foreign_key'))
                                    ->label(__('filament-shield::filament-shield.field.team'))
                                    ->placeholder(__('filament-shield::filament-shield.field.team.placeholder'))
                                    /** @phpstan-ignore-next-line */
                                    ->default(Filament::getTenant()?->id)
                                    ->options(fn (): array => in_array(Utils::getTenantModel(), [null, '', '0'], true) ? [] : Utils::getTenantModel()::pluck('name', 'id')->toArray())
                                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled())
                                    ->dehydrated(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                                static::getSelectAllFormComponent(),

                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                static::getShieldFormComponents(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->weight(FontWeight::Medium)
                    ->label(__('filament-shield::filament-shield.column.name'))
                    ->formatStateUsing(fn (string $state): string => Str::headline($state))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->badge()
                    ->color('warning')
                    ->label(__('filament-shield::filament-shield.column.guard_name')),
                TextColumn::make('team.name')
                    ->default('Global')
                    ->badge()
                    ->color(fn (mixed $state): string => str($state)->contains('Global') ? 'gray' : 'primary')
                    ->label(__('filament-shield::filament-shield.column.team'))
                    ->searchable()
                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                TextColumn::make('permissions_count')
                    ->badge()
                    ->label(__('filament-shield::filament-shield.column.permissions'))
                    ->counts('permissions')
                    ->color('primary'),
                TextColumn::make('updated_at')
                    ->label(__('filament-shield::filament-shield.column.updated_at'))
                    ->dateTime(),
            ])
            ->headerActions([
                Action::make('generate_shield')
                    ->label(__('Generate Permission (DO NOT TRY)'))
                    ->visible(fn() => auth()->user()->hasRole('super_admin'))
                    ->icon('heroicon-o-shield-check')
                    ->action(function (array $data): void {
                        $options = [
                            '--panel' => 'admin', 
                        ];
            
                        if (!empty($data['generate_all'])) {
                            $options['--all'] = true;
                        } else {
                            if (!empty($data['option'])) {
                                $options['--option'] = $data['option'];
                            }
            
                            if (!empty($data['resource'])) {
                                $options['--resource'] = $data['resource'];
                            }
            
                            if (!empty($data['page'])) {
                                $options['--page'] = $data['page'];
                            }
            
                            if (!empty($data['widget'])) {
                                $options['--widget'] = $data['widget'];
                            }
            
                            if (!empty($data['exclude'])) {
                                $options['--exclude'] = true;
                            }
            
                            if (!empty($data['ignore_config_exclude'])) {
                                $options['--ignore-config-exclude'] = true;
                            }
            
                            if (!empty($data['minimal'])) {
                                $options['--minimal'] = true;
                            }
            
                            if (!empty($data['ignore_existing_policies'])) {
                                $options['--ignore-existing-policies'] = true;
                            }
                        }
            
                        Artisan::call('shield:generate', $options);
                        Notification::make()
                            ->title('Sync Success')
                            ->body('Permission generated successfully!')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Toggle::make('generate_all')
                            ->label('Generate for all entities')
                            ->reactive(),
            
                       Select::make('option')
                            ->label('Option')
                            ->options([
                                'policies_and_permissions' => 'Policies and Permissions',
                                'policies' => 'Policies only',
                                'permissions' => 'Permissions only',
                            ])
                            ->placeholder('Select Option'),
            
                        TextInput::make('resource')
                            ->label('Resources (comma separated)')
                            ->placeholder('User,Post')
                            ->visible(fn ($get) => !$get('generate_all')),
            
                        TextInput::make('page')
                            ->label('Pages (comma separated)')
                            ->placeholder('Dashboard,Settings')
                            ->visible(fn ($get) => !$get('generate_all')),
            
                        TextInput::make('widget')
                            ->label('Widgets (comma separated)')
                            ->placeholder('StatsOverview')
                            ->visible(fn ($get) => !$get('generate_all')),
            
                        Toggle::make('exclude')
                            ->label('Exclude the given entities'),
            
                        Toggle::make('ignore_config_exclude')
                            ->label('Ignore config exclude option'),
            
                        Toggle::make('minimal')
                            ->label('Minimal console output'),
            
                        Toggle::make('ignore_existing_policies')
                            ->label('Ignore already existing policies')
                    ])
                    ->modalHeading('Generate Shield Permissions')
                    ->modalSubmitActionLabel('Generate')
                    ->hidden()
                    ->modalWidth('md'),
                Action::make('resetCache')
                    ->label('Reset Cache')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function ($record) {
                        Artisan::call('permission:cache-reset');
                        Notification::make()
                            ->title('Roles Cache reset')
                            ->body('Roles cache reset properly!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Reset Cache')
                    ->modalSubheading('This action will reset the roles cache.')
                    ->modalButton('Yes, do it'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Utils::getRoleModel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getResourceSlug();
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster();
    }

    public static function getEssentialsPlugin(): ?FilamentShieldPlugin
    {
        return FilamentShieldPlugin::get();
    }
}
