<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Réalisations';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Projet';
    protected static ?string $pluralModelLabel = 'Réalisations';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations générales')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Titre')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                        ->columnSpanFull(),
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
                    Forms\Components\TextInput::make('client')
                        ->label('Client')
                        ->required(),
                    Forms\Components\TextInput::make('sector')
                        ->label('Secteur d\'activité')
                        ->required(),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Mis en avant sur la homepage')
                        ->inline(false),
                ])
                ->columns(2),

            Forms\Components\Section::make('Contenu du projet')
                ->schema([
                    Forms\Components\Textarea::make('challenge')
                        ->label('Problématique client')
                        ->required()
                        ->rows(4),
                    Forms\Components\Textarea::make('solution')
                        ->label('Notre solution')
                        ->required()
                        ->rows(4),
                    Forms\Components\Textarea::make('results')
                        ->label('Résultats obtenus')
                        ->required()
                        ->rows(4),
                ])
                ->columns(1),

            Forms\Components\Section::make('Galerie photos')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->label('Images du projet')
                        ->image()
                        ->imageEditor()
                        ->multiple()
                        ->reorderable()
                        ->helperText('Images converties automatiquement en WebP N&B')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('gallery')
                    ->collection('gallery')
                    ->conversion('webp')
                    ->label('')
                    ->circular(false)
                    ->width(60)
                    ->height(40),
                Tables\Columns\TextColumn::make('title')
                    ->label('Projet')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client')
                    ->label('Client')
                    ->searchable(),
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
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Homepage')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
                Tables\Filters\TernaryFilter::make('is_featured')->label('Mis en avant'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_featured')
                    ->label(fn ($record) => $record->is_featured ? 'Retirer homepage' : 'Mettre en avant')
                    ->icon(fn ($record) => $record->is_featured ? 'heroicon-o-star' : 'heroicon-o-star')
                    ->color(fn ($record) => $record->is_featured ? 'warning' : 'success')
                    ->action(fn ($record) => $record->update(['is_featured' => !$record->is_featured])),
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
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
