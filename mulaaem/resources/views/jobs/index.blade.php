<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Open Positions</h1>
            <p class="mt-2 text-gray-600">Find your next role with AI-powered matching.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
                <a href="{{ route('jobs.show', $job->slug) }}" class="block bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-500 transition">
                    <div class="mb-4">
                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-50 text-blue-700 rounded mb-2">
                            {{ $job->type->getLabel() }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $job->location }}</p>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-400 mt-4 pt-4 border-t border-gray-100">
                        <span>{{ $job->salary_range ?? 'Competitive' }}</span>
                        <span class="text-blue-600 font-medium">View &rarr;</span>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">No jobs available right now.</p>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>
</x-app-layout>