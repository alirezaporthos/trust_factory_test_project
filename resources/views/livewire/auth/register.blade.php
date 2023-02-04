<form wire:submit.prevent="register">

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="'name'"/>
        <x-text-input  wire:model.lazy="name" id="name" @class(["block mt-1 w-full", "border-red-500" => $errors->has("name")]) type="text" autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email"  :value="'email'"/>
        <x-text-input wire:model.lazy="email" @class(["block mt-1 w-full", "border-red-500" => $errors->has("email")]) type="email" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="'Password'" />
        <x-text-input wire:model="password" @class(["block mt-1 w-full", "border-red-500" => $errors->has("password")]) type="password" autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="passwordConfirmation" :value="'Confirm Password'" />
        <x-text-input wire:model="passwordConfirmation" @class(["block mt-1 w-full", "border-red-500" => $errors->has("password")]) type="password"/>
        <x-input-error :messages="$errors->get('passwordConfirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a> --}}

        <x-primary-button class="ml-4">
            {{'Register'}}
        </x-primary-button>
    </div>
</form>

