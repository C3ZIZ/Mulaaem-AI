<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Infolists\Components\Section::make('Overview')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')->label('Candidate'),
                        Infolists\Components\TextEntry::make('user.email')->label('Email')->copyable(),
                        Infolists\Components\TextEntry::make('jobListing.title')->label('Applied For'),
                        Infolists\Components\TextEntry::make('status')->badge(),
                    ])->columns(2),

                Infolists\Components\Section::make('AI Assessment')
                    ->schema([
                        Infolists\Components\TextEntry::make('ai_score')
                            ->label('Match Score')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        
                        // --- FIX STARTS HERE ---
                        // We use TextEntry with code() instead of KeyValueEntry
                        // This prevents the "Array to String" crash
                        Infolists\Components\TextEntry::make('ai_analysis_data')
                            ->label('Detailed Analysis')
                            ->columnSpanFull()
                            ->code() // Makes it look like a code snippet
                            ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)), 
                        // --- FIX ENDS HERE ---
                    ]),
            ]);
    }
}