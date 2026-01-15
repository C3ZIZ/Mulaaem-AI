<?php

namespace App\Filament\Resources\JobListings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use App\Enums\JobType;

class JobListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Job Details')->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => 
                            $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Select::make('type')
                        ->options(JobType::class) // Using Enum
                        ->required(),

                    RichEditor::make('description')
                        ->required()
                        ->columnSpanFull(),

                    Textarea::make('requirements_for_ai')
                        ->label('AI Scoring Criteria')
                        ->helperText('Internal instructions for the AI.')
                        ->columnSpanFull(),
                ])->columns(2),

                Section::make('Logistics')->schema([
                    TextInput::make('location')->required(),
                    TextInput::make('salary_range')->placeholder('$50k - $80k'),
                    DatePicker::make('closes_at')->minDate(now()),
                    Toggle::make('is_active')->default(true),
                ])->columns(2),
            ]);
    }
}