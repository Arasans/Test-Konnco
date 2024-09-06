<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                                        ->searchable(),
                Tables\Columns\TextColumn::make('status')
                                        ->searchable(),
                Tables\Columns\TextColumn::make('name')
                                        ->searchable(),
                Tables\Columns\TextColumn::make('email')
                                        ->searchable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('order_id');

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
            'index' => Pages\ListTransactions::route('/'),
        ];
    }
}
