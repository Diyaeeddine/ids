<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier l'utilisateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('acce.update', $user->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="mt-1 block w-full" 
                            :value="old('name', $user->name)" 
                            required 
                            autofocus 
                            autocomplete="name" 
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input 
                            id="email" 
                            name="email" 
                            type="email" 
                            class="mt-1 block w-full" 
                            :value="old('email', $user->email)" 
                            required 
                            autocomplete="email" 
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Mettre à jour') }}</x-primary-button>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Profile mis à jour avec succès.') }}
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
