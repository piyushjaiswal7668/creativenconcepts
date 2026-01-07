<?php

namespace App\Filament\Resources\Concerns;

trait ChecksPermissions
{
    protected static function canWithPermission(string $action): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->can($action . '_' . static::permissionResource());
    }

    protected static function permissionResource(): string
    {
        return '';
    }

    public static function canViewAny(): bool
    {
        return static::canWithPermission('view_any');
    }

    public static function canView($record): bool
    {
        return static::canWithPermission('view');
    }

    public static function canCreate(): bool
    {
        return static::canWithPermission('create');
    }

    public static function canEdit($record): bool
    {
        return static::canWithPermission('update');
    }

    public static function canDelete($record): bool
    {
        return static::canWithPermission('delete');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }
}
