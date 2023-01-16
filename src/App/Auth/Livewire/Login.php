<?php

namespace App\Auth\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public string $username = '';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('username')->required(),
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('auth.login');
    }
}
