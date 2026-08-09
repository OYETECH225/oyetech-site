<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationLabel = 'Leads';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?int $navigationSort = 10;
    protected static ?string $modelLabel = 'Lead';
    protected static ?string $pluralModelLabel = 'Leads';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contact')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom')
                        ->required()
                        ->disabled(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->disabled(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->disabled(),
                    Forms\Components\TextInput::make('company')
                        ->label('Entreprise')
                        ->disabled(),
                    Forms\Components\TextInput::make('country')
                        ->label('Pays')
                        ->disabled(),
                    Forms\Components\TextInput::make('budget')
                        ->label('Budget')
                        ->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Demande')
                ->schema([
                    Forms\Components\Select::make('pole')
                        ->label('Pôle concerné')
                        ->options([
                            'conseil'       => 'Conseil & Stratégie',
                            'communication' => 'Communication & Publicité',
                            'marketing'     => 'Marketing Digital',
                            'solutions'     => 'Solutions Numériques',
                            'ilepay'        => 'Ilepay',
                        ])
                        ->disabled(),
                    Forms\Components\Select::make('status')
                        ->label('Statut')
                        ->options([
                            'new'       => 'Nouveau',
                            'contacted' => 'Contacté',
                            'qualified' => 'Qualifié',
                            'lost'      => 'Perdu',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('message')
                        ->label('Message')
                        ->rows(6)
                        ->disabled()
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->description(fn ($record) => $record->company),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('pole')
                    ->label('Pôle')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'conseil'       => 'info',
                        'communication' => 'warning',
                        'marketing'     => 'success',
                        'solutions'     => 'primary',
                        'ilepay'        => 'danger',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'conseil'       => 'Conseil',
                        'communication' => 'Communication',
                        'marketing'     => 'Marketing',
                        'solutions'     => 'Solutions',
                        'ilepay'        => 'Ilepay',
                        default         => $state ?? '—',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'contacted' => 'warning',
                        'qualified' => 'success',
                        'lost'      => 'gray',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'new'       => 'Nouveau',
                        'contacted' => 'Contacté',
                        'qualified' => 'Qualifié',
                        'lost'      => 'Perdu',
                        default     => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'new'       => 'Nouveau',
                        'contacted' => 'Contacté',
                        'qualified' => 'Qualifié',
                        'lost'      => 'Perdu',
                    ]),
                Tables\Filters\SelectFilter::make('pole')
                    ->label('Pôle')
                    ->options([
                        'conseil'       => 'Conseil & Stratégie',
                        'communication' => 'Communication & Publicité',
                        'marketing'     => 'Marketing Digital',
                        'solutions'     => 'Solutions Numériques',
                        'ilepay'        => 'Ilepay',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Voir'),
                Tables\Actions\Action::make('mark_contacted')
                    ->label('Contacté')
                    ->icon('heroicon-o-phone')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'new')
                    ->action(fn ($record) => $record->update(['status' => 'contacted'])),
                Tables\Actions\Action::make('mark_qualified')
                    ->label('Qualifié')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => in_array($record->status, ['new', 'contacted']))
                    ->action(function ($record) {
                        $record->update(['status' => 'qualified']);
                        Notification::make()->title('Lead qualifié')->success()->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit'   => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
