<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestCourses extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Course::query()->latest()->take(5))
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
            ])->paginated(false);
    }
}
