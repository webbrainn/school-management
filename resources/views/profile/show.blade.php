<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')
            <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-password-form')
            </div>
            <x-section-border />
            @endif

            @php
            $dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' :
            (auth()->user()->hasRole('teacher') ? 'teacher.dashboard' :
            (auth()->user()->hasRole('student') ? 'student.dashboard' : 'dashboard'));
            @endphp
            <div class="text-center mt-4">
            <a href="{{ route($dashboardRoute) }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Back to Dashboard
            </a>
            </div>

        </div>
    </div>
</x-app-layout>