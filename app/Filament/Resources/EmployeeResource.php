<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use App\Traits\GetsFiltersLogic;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class EmployeeResource extends Resource
{
    use GetsFiltersLogic;

    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'first_name';

    protected static ?string $label = 'Alkalmazott';

    protected static ?string $pluralModelLabel = 'alkalmazottak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('last_name')
                    ->label('Vezetéknév')
                    ->required(),

                Forms\Components\TextInput::make('first_name')
                    ->label('Keresztnév')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('E-mail cím')
                    ->unique()
                    ->email(),

                Forms\Components\TextInput::make('phone')
                    ->label('Telefonszám'),

                Forms\Components\Select::make('company_id')
                    ->label('Cég')
                    ->relationship('company', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $filters = [
            [
                'key' => 'last_name',
                'label' => 'Vezetéknév',
                'column' => 'last_name',
            ],
            [
                'key' => 'first_name',
                'label' => 'Keresztnév',
                'column' => 'first_name',
            ],
            [
                'key' => 'email',
                'label' => 'E-mail cím',
                'column' => 'email',
            ],
            [
                'key' => 'phone',
                'label' => 'Telefonszám',
                'column' => 'phone',
            ],
            [
                'key' => 'company',
                'label' => 'Cég',
                'column' => 'company_id',
                'relation' => 'company',
                'relation_column' => 'name',
            ],
        ];

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Vezetéknév'),

                Tables\Columns\TextColumn::make('first_name')
                    ->label('Keresztnév'),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail cím')
                    ->url(fn ($record) => "mailto:$record->email"),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefonszám')
                    ->url(fn ($record) => "tel:$record->email"),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('Cég'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

}
