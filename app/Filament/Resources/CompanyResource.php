<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use App\Traits\GetsFiltersLogic;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CompanyResource extends Resource
{
    use GetsFiltersLogic;

    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 0;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Cég';

    protected static ?string $pluralModelLabel = 'cégek';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Megnevezés')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('E-mail cím')
                    ->unique()
                    ->email(),

                Forms\Components\TextInput::make('website')
                    ->label('Weboldal URL címe')
                    ->url(),

                Forms\Components\FileUpload::make('logo_path')
                    ->image()
                    ->label('Logó'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $filters = [
            [
                'key' => 'name',
                'label' => 'Megnevezés',
                'column' => 'name',
            ],
            [
                'key' => 'email',
                'label' => 'E-mail cím',
                'column' => 'email',
            ],
            [
                'key' => 'website',
                'label' => 'Weboldal URL címe',
                'column' => 'website',
            ],
        ];

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logó'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Megnevezés'),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail cím'),

                Tables\Columns\TextColumn::make('website')
                    ->label('Weboldal URL címe'),
            ])
            ->filters(self::getFilters($filters))
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
