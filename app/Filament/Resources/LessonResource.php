<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Courses managements";

    public static function form(Form $form): Form
    {
        $isEditing = $form->getRecord() != null;
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('video')
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('description')
                                ->required(),
                        ])->columns(2),
                        Forms\Components\FileUpload::make("video_file")
                            ->hint( !$isEditing ? null : "Click on the open icon to open the video once uploaded.")
                            ->acceptedFileTypes(["video/mp4"])
                            ->openable($isEditing)
                            ->previewable(!$isEditing)
                            ->required(),
                    ])->columnSpanFull(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'view' => Pages\ViewLesson::route('/{record}'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
