<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->required()
                    ->label('First Name')
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->required()
                    ->label('Last Name')
                    ->maxLength(255),

                TextInput::make('full_name')
                    ->label('Full Name')
                    ->disabled()
                    ->default(function ($record) {
                        return $record ? $record->full_name : '';
                    }),

                TextInput::make('phone')
                    ->required()
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('city')
                    ->required()
                    ->label('City')
                    ->maxLength(255),

                TextInput::make('state')
                    ->required()
                    ->label('State')
                    ->maxLength(255),

                TextInput::make('zip_code')
                    ->required()
                    ->label('ZIP Code')
                    ->numeric()
                    ->maxLength(20),

                Textarea::make('street_address')
                    ->required()
                    ->label('Street Address')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_address')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(function ($record) {
                        return $record->first_name . ' ' . $record->last_name;
                    }),
                TextColumn::make('phone')
                    ->label('Phone Number'),

                TextColumn::make('city')
                    ->label('City'),

                TextColumn::make('state')
                    ->label('State'),

                TextColumn::make('zip_code')
                    ->label('ZIP Code'),

                TextColumn::make('street_address')
                    ->label('Street Address')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
