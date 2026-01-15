<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('jobs.index') }}" class="text-sm text-gray-500 hover:text-blue-600 mb-6 inline-block">&larr; Back to Jobs</a>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
            <div class="flex gap-4 text-sm text-gray-600 mb-8">
                <span>{{ $job->location }}</span> &bull; <span>{{ $job->type->getLabel() }}</span>
            </div>
            
            <div class="prose max-w-none text-gray-700">
                {!! $job->description !!}
            </div>
        </div>

        <div class="bg-blue-50 rounded-xl border border-blue-100 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Apply Now</h2>
            
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4">{{ session('error') }}</div>
            @endif

            <form action="{{ route('applications.store', $job->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Resume (PDF)</label>
                    <input type="file" name="resume" accept=".pdf" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition">
                    Submit Application
                </button>
            </form>
        </div>
    </div>
</x-app-layout>