<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Témoignages';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Témoignage';
    protected static ?string $pluralModelLabel = 'Témoignages';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Auteur')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('photo')
                        ->collection('photo')
                        ->label('Photo')
                        ->image()
                        ->imageEditor()
                        ->avatar()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('author_name')
                        ->label('Nom')
                        ->required(),
                    Forms\Components\TextInput::make('author_role')
                        ->label('Poste / Fonction'),
                    Forms\Components\TextInput::make('company')
                        ->label('Entreprise')
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Témoignage')
                ->schema([
                    Forms\Components\Textarea::make('content')
                        ->label('Contenu du témoignage')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('rating')
                        ->label('Note')
                        ->options([1 => '⭐', 2 => '⭐⭐', 3 => '⭐⭐⭐', 4 => '⭐⭐⭐⭐', 5 => '⭐⭐⭐⭐⭐'])
                        ->required()
                        ->default(5),
                    Forms\Components\TextInput::make('order')
                        ->label('Ordre d\'affichage')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Visible')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('photo')
                    ->conversion('webp')
                    ->label('')
                    ->circular()
                    ->width(40)
                    ->height(40),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Auteur')
                    ->searchable()
                    ->description(fn ($record) => "{$record->author_role} — {$record->company}"),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Note')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),
                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Visible'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Masquer' : 'Afficher')
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
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
