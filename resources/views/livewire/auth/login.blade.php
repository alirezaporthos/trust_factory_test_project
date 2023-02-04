<form wire:submit.prevent="login" method="POST" action="#">

    <div>
        <x-input-label for="email" value="email" />
        <x-text-input wire:model="email" id="email" @class(["block mt-1 w-full", "border-red-500" => $errors->has("email")]) type="email" name="email" :value="old('email')" required autofocus />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="password" value="password" />

        <x-text-input wire:model="password" id="password" @class(["block mt-1 w-full", "border-red-500" => $errors->has("password")])
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>


    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-3">
            Log in
        </x-primary-button>
    </div>
</form>
