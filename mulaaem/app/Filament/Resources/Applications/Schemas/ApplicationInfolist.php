<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Overview')
                    ->schema([
                        TextEntry::make('user.name')->label('Candidate'),
                        TextEntry::make('user.email')->label('Email')->copyable(),
                        TextEntry::make('jobListing.title')->label('Applied For'),
                        TextEntry::make('status')->badge(),
                    ])->columns(2),

                Section::make('AI Assessment')
                    ->schema([
                        TextEntry::make('ai_score')
                            ->label('Match Score')
                            ->size(TextEntrySize::Large)
                            ->weight('bold'),
                        
                        KeyValueEntry::make('ai_analysis_data')
                            ->label('Breakdown'),
                    ]),
            ]);
    }
}