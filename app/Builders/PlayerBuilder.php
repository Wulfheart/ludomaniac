<?php

namespace app\Builders;

use Illuminate\Database\Eloquent\Builder;

class PlayerBuilder extends Builder
{
    // TODO: test
    public function whereDoesntHaveAnAssignedUser(): self
    {
        return $this->whereDoesntHave('user');
    }
}
