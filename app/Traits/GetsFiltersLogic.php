<?php

namespace App\Traits;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

trait GetsFiltersLogic
{
    /**
     * Returns the filter logics to Filament Resources.
     *
     * @param array $filterConfigs
     *
     * @return array
     */
    public static function getFilters(array $filterConfigs): array
    {
        $filters = [];

        foreach ($filterConfigs as $filterConfig) {
            if (isset($filterConfig['relation'])) {
                $filters[] = self::getRelationFilterLogic($filterConfig);
            }

            if (! isset($filterConfig['relation'])) {
                $filters[] = self::getColumnFilterLogic($filterConfig);
            }
        }

        return $filters;
    }

    /**
     * Returns the relation filter logic.
     *
     * @param array $filterConfig
     *
     * @return SelectFilter
     */
    public static function getRelationFilterLogic(array $filterConfig): SelectFilter
    {
        return SelectFilter::make('company_id')
            ->label('Cégek')
            ->relationship('company', 'name')
            ->multiple();
    }

    /**
     * Returns the column filter logic.
     *
     * @param array $filterConfig
     *
     * @return Filter
     */
    public static function getColumnFilterLogic(array $filterConfig): Filter
    {
        return Filter::make($filterConfig['key'])
            ->form([
                TextInput::make($filterConfig['key'])->label($filterConfig['label']),
            ])
            ->query(function (Builder $query, array $data) use ($filterConfig): Builder {
                return $query
                    ->when(
                        $data[$filterConfig['column']],
                        function (Builder $query, string $title) use ($filterConfig) {
                            $query->where($filterConfig['column'], 'LIKE', "%{$title}%");
                        },
                    );
            });
    }
}
