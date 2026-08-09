<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Articles';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'Article';
    protected static ?string $pluralModelLabel = 'Articles';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations')
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
                    Forms\Components\Select::make('category')
                        ->label('Catégorie')
                        ->options([
                            'Innovation' => 'Innovation',
                            'Fintech'    => 'Fintech',
                            'Marketing'  => 'Marketing',
                            'Stratégie'  => 'Stratégie',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Image de couverture')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->label('Image')
                        ->image()
                        ->imageEditor()
                        ->helperText('Convertie automatiquement en WebP N&B 1200px')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Contenu')
                ->schema([
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Chapô (résumé)')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->label('Corps de l\'article')
                        ->required()
                        ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote', 'link', 'codeBlock'])
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Publication & SEO')
                ->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->label('Publié')
                        ->default(false)
                        ->live()
                        ->inline(false),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Date de publication')
                        ->native(false)
                        ->visible(fn ($get) => $get('is_published')),
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta titre (SEO)')
                        ->maxLength(70)
                        ->helperText('Max 70 caractères'),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta description (SEO)')
                        ->rows(2)
                        ->maxLength(160)
                        ->helperText('Max 160 caractères'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->conversion('webp')
                    ->label('')
                    ->width(60)
                    ->height(40),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(60),
                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publié le')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('Brouillon'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Publié'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options([
                        'Innovation' => 'Innovation',
                        'Fintech'    => 'Fintech',
                        'Marketing'  => 'Marketing',
                        'Stratégie'  => 'Stratégie',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label(fn ($record) => $record->is_published ? 'Dépublier' : 'Publier')
                    ->icon(fn ($record) => $record->is_published ? 'heroicon-o-arrow-down-circle' : 'heroicon-o-arrow-up-circle')
                    ->color(fn ($record) => $record->is_published ? 'warning' : 'success')
                    ->action(function ($record) {
                        $record->update([
                            'is_published' => !$record->is_published,
                            'published_at' => !$record->is_published ? now() : $record->published_at,
                        ]);
                        Notification::make()
                            ->title($record->is_published ? 'Article publié' : 'Article dépublié')
                            ->success()
                            ->send();
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
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
