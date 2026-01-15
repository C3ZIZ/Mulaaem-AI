<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use App\Enums\ApplicationStatus;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Left: Read-Only Candidate Info
                Section::make('Candidate Profile')->schema([
                    TextInput::make('user.name')
                        ->label('Name')
                        ->disabled(),
                    
                    TextInput::make('user.email')
                        ->label('Email')
                        ->disabled(),

                    FileUpload::make('resume_path')
                        ->label('Resume PDF')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled() // No deleting allowed
                        ->columnSpanFull(),
                ])->columns(2),

                // Right: Action & AI Results
                Section::make('Review & Action')->schema([
                    Select::make('status')
                        ->options(ApplicationStatus::class) // Enum
                        ->required()
                        ->native(false),

                    TextInput::make('ai_score')
                        ->label('AI Match Score')
                        ->disabled(),

                    KeyValue::make('ai_analysis_data')
                        ->label('AI Feedback')
                        ->disabled()
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }
}