<?php

namespace App\Filament\Resources;

use app\Models\User;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Model;

trait PartiallyEditable
{
    /**
     * @param \Closure(User $user, Model $record): bool $editCallback
     * @return \Closure(Page $livewire, AuthManager $authManager, ?Model $record): bool
     */
    protected static function allowedToModify(\Closure $editCallback): \Closure
    {
        return function (Page $livewire, AuthManager $authManager, ?Model $record) use ($editCallback): bool {
            if ($livewire instanceof CreateRecord) {
                return true;
            }

            if ($livewire instanceof EditRecord) {
                $user = $authManager->user();
                if ($user instanceof User) {
                    return $editCallback($user, $record);
                }
                throw new \TypeError('User is not an instance of '.User::class);
            }

            return false;
        };
    }
}
