
<img src="{{ asset('admin/image/webBrain-Logo.png') }}" alt="Company Logo"
     style="position: absolute; top: 20px; left: 20px; height: 40px; width: auto; z-index: 50;">

<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
             <div class="flex justify-center mb-6">
               <!-- <img src="{{ asset('admin/image/webBrain-Logo.png') }}" alt="School Logo" class="h-20 w-auto mx-auto"> -->
                <img src="{{ asset('admin/image/school-logo.png') }}" alt="School Logo" class="" style="height:140px; width:160px;">
             </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <!-- <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div> -->

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <div class="relative">
                    <x-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                             autocomplete="current-password" /> 
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-600 p-2">
                        <i id="eyeIcon" class="fa-solid fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <div class="block mt-4 p-2">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye"); // Change to eye open
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash"); // Change back to eye closed
        }
    }
</script>
