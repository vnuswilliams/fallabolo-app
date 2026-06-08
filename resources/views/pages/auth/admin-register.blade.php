<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Créer un compte MatchRH')" :description="__('Rejoignez la plateforme de recrutement au mérite du Cameroun')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:radio.group variant="segmented"  name="role">
                <flux:radio  value="{{ \App\Enums\RoleEnum::ADMIN->value }}" icon="shield-check" checked>{{ __('I am the admin') }}</flux:radio>
            </flux:radio.group>

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"

                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"

                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"

                autocomplete="new-password"
                :placeholder="__('Password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"

                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <flux:checkbox.group label="Subscription preferences" variant="cards" class="flex-col">
                <flux:checkbox checked name="agree">
                    <flux:checkbox.indicator />

                    <div class="flex-1">
                        <flux:heading class="leading-4">Terms and conditions</flux:heading>
                        <flux:text>J'accepte les <flux:link href="/terms">conditions générales d'utilisation</flux:link> et reconnais avoir pris connaissances des <flux:link href="/privacy">politiques de confidentialité</flux:link></flux:text>

                    </div>
                </flux:checkbox>

                <flux:checkbox name="updates">
                    <flux:checkbox.indicator />

                    <div class="flex-1">
                        <flux:heading class="leading-4">Product updates</flux:heading>
                        <flux:text size="sm" class="mt-2">Learn about new features and products.</flux:text>
                    </div>
                </flux:checkbox>
            </flux:checkbox.group>


            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
