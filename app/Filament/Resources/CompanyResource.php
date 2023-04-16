<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class CompanyResource extends Resource
{
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
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('Megnevezés'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['name'],
                                function (Builder $query, string $name) {
                                    $query->where('name', 'LIKE', "%{$name}%");
                                },
                            );
                    }),

                Tables\Filters\Filter::make('email')
                    ->form([
                        Forms\Components\TextInput::make('email')->label('E-mail cím'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['email'],
                                function (Builder $query, string $title) {
                                    $query->where('email', 'LIKE', "%{$title}%");
                                },
                            );
                    }),

                Tables\Filters\Filter::make('website')
                    ->form([
                        Forms\Components\TextInput::make('website')->label('Weboldal URL címe'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['website'],
                                function (Builder $query, string $title) {
                                    $query->where('website', 'LIKE', "%{$title}%");
                                },
                            );
                    }),
            ])
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
