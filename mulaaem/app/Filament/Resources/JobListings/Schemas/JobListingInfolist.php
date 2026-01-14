<?php

namespace App\Filament\Resources\JobListings\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class JobListingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Overview')
                    ->schema([
                        TextEntry::make('title')->weight('bold'),
                        TextEntry::make('type')->badge(),
                        TextEntry::make('location'),
                        TextEntry::make('salary_range'),
                    ])->columns(4),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->html() // Render HTML from RichEditor
                            ->prose(),
                    ]),
            ]);
    }
}