<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Enums\ApplicationStatus;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Candidate')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('jobListing.title')
                    ->label('Role')
                    ->limit(25),

                // Score  (Red/Yellow/Green)
                TextColumn::make('ai_score')
                    ->label('AI Match')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 80 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('status')
                    ->badge(), // Auto-colors from Enum

                TextColumn::make('created_at')
                    ->label('Applied')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('ai_score', 'desc') // Best candidates intop
            ->filters([
                SelectFilter::make('status')
                    ->options(ApplicationStatus::class),
                
                SelectFilter::make('job_listing')
                    ->relationship('jobListing', 'title'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}