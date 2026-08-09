<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Service';
    protected static ?string $pluralModelLabel = 'Services';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations générales')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom du service')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('pole')
                        ->label('Pôle')
                        ->options([
                            'conseil'       => 'Conseil & Stratégie',
                            'communication' => 'Communication & Publicité',
                            'marketing'     => 'Marketing Digital',
                            'solutions'     => 'Solutions Numériques',
                            'ilepay'        => 'Ilepay',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('icon')
                        ->label('Icône Heroicon')
                        ->placeholder('heroicon-o-light-bulb')
                        ->helperText('Nom complet de l\'icône Heroicon'),
                    Forms\Components\TextInput::make('order')
                        ->label('Ordre d\'affichage')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Publié')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),

            Forms\Components\Section::make('Contenu')
                ->schema([
                    Forms\Components\Textarea::make('summary')
                        ->label('Résumé (affiché sur la homepage)')
                        ->required()
                        ->rows(3),
                    Forms\Components\RichEditor::make('description')
                        ->label('Description complète')
                        ->required()
                        ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3', 'link']),
                    Forms\Components\TagsInput::make('deliverables')
                        ->label('Livrables')
                        ->placeholder('Ajouter un livrable…'),
                ]),

            Forms\Components\Section::make('Images')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->label('Image principale')
                        ->image()
                        ->imageEditor()
                        ->helperText('Image mise en avant pour ce service (convertie en WebP automatiquement)')
                        ->columnSpanFull(),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->label('Galerie d\'images')
                        ->image()
                        ->imageEditor()
                        ->multiple()
                        ->reorderable()
                        ->helperText('Images supplémentaires pour la page détail du service')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->conversion('thumb')
                    ->label('')
                    ->width(60)
                    ->height(40),
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pole')
                    ->label('Pôle')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'conseil'       => 'info',
                        'communication' => 'warning',
                        'marketing'     => 'success',
                        'solutions'     => 'primary',
                        'ilepay'        => 'danger',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'conseil'       => 'Conseil & Stratégie',
                        'communication' => 'Communication',
                        'marketing'     => 'Marketing',
                        'solutions'     => 'Solutions',
                        'ilepay'        => 'Ilepay',
                        default         => $state,
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Publié')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('pole')
                    ->label('Pôle')
                    ->options([
                        'conseil'       => 'Conseil & Stratégie',
                        'communication' => 'Communication & Publicité',
                        'marketing'     => 'Marketing Digital',
                        'solutions'     => 'Solutions Numériques',
                        'ilepay'        => 'Ilepay',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')->label('Publié'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Dépublier' : 'Publier')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                    ->action(fn ($record) => $record->update(['is_active' => !$record->is_active])),
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
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
