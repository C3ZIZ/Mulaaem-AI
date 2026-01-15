<?php

namespace App\Filament\Resources\JobListings;

use App\Filament\Resources\JobListings\Pages\CreateJobListing;
use App\Filament\Resources\JobListings\Pages\EditJobListing;
use App\Filament\Resources\JobListings\Pages\ListJobListings;
use App\Filament\Resources\JobListings\Pages\ViewJobListing;
use App\Filament\Resources\JobListings\Schemas\JobListingForm;
use App\Filament\Resources\JobListings\Schemas\JobListingInfolist;
use App\Filament\Resources\JobListings\Tables\JobListingsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\JobListing;
use App\Enums\UserRole;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

// MUST be exactly this type signature:
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedBriefcase;

    // MUST be exactly this type signature:
    protected static string | \UnitEnum | null $navigationGroup = 'Recruitment';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return JobListingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobListingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobListingsTable::configure($table);
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
            'index' => ListJobListings::route('/'),
            'create' => CreateJobListing::route('/create'),
            'view' => ViewJobListing::route('/{record}'),
            'edit' => EditJobListing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        if (! auth()->user()?->hasRole(UserRole::Admin->value)) {
            $query->where('recruiter_id', auth()->id());
        }

        return $query;
    }
}