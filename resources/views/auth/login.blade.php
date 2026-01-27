@extends('layouts.app')

{{-- Page de connexion --}}

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        {{-- Logo et titre --}}
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-sign-in-alt text-blue-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Se connecter</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Entrez vos informations pour accéder à votre compte</p>
        </div>

        {{-- Formulaire de connexion --}}
        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Champ Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                <input id="email" name="email" type="email" required autofocus
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                       value="{{ old('email') }}" placeholder="exemple@email.com">
                {{-- Afficher les erreurs de validation pour l'email --}}
                @if($errors->has('email'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </div>

            {{-- Champ Mot de passe --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                       placeholder="Votre mot de passe">
                {{-- Afficher les erreurs de validation pour le mot de passe --}}
                @if($errors->has('password'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </div>

            {{-- Checkbox "Se souvenir de moi" et lien "Mot de passe oublié" --}}
            <div class="flex items-center justify-between">
                {{-- Checkbox Se souvenir --}}
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>

                {{-- Lien Mot de passe oublié --}}
                <div class="text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">Mot de passe oublié ?</a>
                    @endif
                </div>
            </div>

            {{-- Bouton de soumission --}}
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                    Se connecter
                </button>
            </div>

            {{-- Lien vers l'inscription --}}
            <div class="text-center">
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Pas encore de compte ? Inscrivez-vous</a>
            </div>
        </form>
    </div>
</div>
@endsection
