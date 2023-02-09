<?php

namespace app\Filament\Helpers;

use app\Enums\GameEndTypeEnum;

class GameEndTypeEnumHelper
{
    /**
     * @param  array<GameEndTypeEnum>  $enum
     */
    public static function formatForFilamentSelect(array $enum): array
    {
        return collect($enum)
            ->pluck('value', 'name')
            ->flip()
            ->map(fn (string $value) => __('core/game.states.game_end_type.'.$value))
            ->toArray();
    }
}
