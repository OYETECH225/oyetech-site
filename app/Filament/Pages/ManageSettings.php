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
    protected static ?string $navigationLabel = 'Paramètres';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 99;
    protected static ?string $title = 'Paramètres du site';
    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'hero_badge'    => Setting::get('hero_badge', 'Agence Digitale · Abidjan · Côte d\'Ivoire'),
            'hero_subtitle' => Setting::get('hero_subtitle', 'Cabinet stratégique et agence digitale 360°, OYETECH accompagne les entreprises et institutions de référence dans leur transformation et leur croissance.'),
            'hero_title'    => Setting::get('hero_title', 'Stratégie, communication et solutions digitales pour faire grandir les entreprises africaines'),

            'stat_projects'           => Setting::get('stat_projects', '120+'),
            'stat_projects_label'     => Setting::get('stat_projects_label', 'Projets livrés'),
            'stat_satisfaction'       => Setting::get('stat_satisfaction', '98%'),
            'stat_satisfaction_label' => Setting::get('stat_satisfaction_label', 'Satisfaction client'),

            'cta_title'    => Setting::get('cta_title', 'Prêt à transformer votre ambition en résultats ?'),
            'cta_subtitle' => Setting::get('cta_subtitle', 'Parlons de votre projet et construisons ensemble la prochaine étape de votre croissance.'),
            'cta_button'   => Setting::get('cta_button', 'Démarrer un projet'),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Notification::make()->title('Paramètres sauvegardés')->success()->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section Hero')
                    ->icon('heroicon-o-home')
                    ->description('Textes affichés dans la section d\'accueil en haut de la homepage.')
                    ->schema([
                        Forms\Components\TextInput::make('hero_badge')
                            ->label('Badge d\'en-tête')
                            ->placeholder('Agence Digitale · Abidjan · Côte d\'Ivoire')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('hero_subtitle')
                            ->label('Sous-titre')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('hero_title')
                            ->label('Titre principal (H1)')
                            ->rows(2)
                            ->maxLength(160)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Statistiques')
                    ->icon('heroicon-o-chart-bar')
                    ->description('Chiffres clés affichés dans le hero. Les années d\'expertise sont calculées automatiquement depuis l\'année de création (config/entreprise.php).')
                    ->schema([
                        Forms\Components\TextInput::make('stat_projects')->label('Valeur — Projets')->placeholder('120+'),
                        Forms\Components\TextInput::make('stat_projects_label')->label('Label — Projets')->placeholder('Projets livrés'),
                        Forms\Components\TextInput::make('stat_satisfaction')->label('Valeur — Satisfaction')->placeholder('98%'),
                        Forms\Components\TextInput::make('stat_satisfaction_label')->label('Label — Satisfaction')->placeholder('Satisfaction client'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Bandeau CTA')
                    ->icon('heroicon-o-megaphone')
                    ->description('Le bandeau d\'appel à l\'action en bas de la homepage.')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')
                            ->label('Titre du CTA')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('cta_subtitle')
                            ->label('Sous-titre du CTA')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('cta_button')
                            ->label('Texte du bouton CTA'),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }
}
