<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $title = 'Settings';

    protected static ?string $navigationLabel = 'Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::getValue('company_name', 'SkyDatum Aerial Survey'),
            'company_phone' => Setting::getValue('company_phone', '(512) 555-0138'),
            'company_email' => Setting::getValue('company_email', 'fly@skydatum.aero'),
            'whatsapp' => Setting::getValue('whatsapp', '15125550138'),
            'service_area' => Setting::getValue('service_area', 'Austin, Round Rock, San Marcos, Georgetown & Central Texas'),
            'tax_rate' => Setting::getValue('tax_rate', '8.25'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')->required(),
                Forms\Components\TextInput::make('company_phone'),
                Forms\Components\TextInput::make('company_email')->email(),
                Forms\Components\TextInput::make('whatsapp')->helperText('Digits only for wa.me link'),
                Forms\Components\TextInput::make('service_area'),
                Forms\Components\TextInput::make('tax_rate')->numeric()->suffix('%'),
            ])
            ->statePath('data')
            ->columns(2);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        foreach ($state as $key => $value) {
            Setting::setValue($key, (string) $value);
        }

        Notification::make()->title('Settings saved')->success()->send();
    }
}