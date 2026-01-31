@extends('layouts.app')

@section('title', 'Politique de confidentialité - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow p-8">
            <h1 class="text-2xl font-bold mb-4">Politique de confidentialité</h1>

            <p class="text-gray-700 mb-4">La présente politique de confidentialité explique comment nous collectons, utilisons, partageons et protégeons les données personnelles que vous nous fournissez lorsque vous utilisez la plateforme UniLomé.</p>

            <h2 class="font-semibold mt-4">1. Données collectées</h2>
            <p class="text-gray-600">Nous collectons les informations nécessaires au fonctionnement du service, notamment : nom, adresse e-mail, rôle (étudiant/université), et données liées au profil et aux formations.</p>

            <h2 class="font-semibold mt-4">2. Finalités du traitement</h2>
            <p class="text-gray-600">Les données sont utilisées pour gérer les comptes, fournir les fonctionnalités de la plateforme, envoyer des notifications et améliorer nos services.</p>

            <h2 class="font-semibold mt-4">3. Partage et divulgation</h2>
            <p class="text-gray-600">Nous ne vendons pas vos données. Nous pouvons partager des informations avec des prestataires techniques (hébergement, envoi d'e-mails) et les administrateurs pour la vérification des comptes.</p>

            <h2 class="font-semibold mt-4">4. Conservation</h2>
            <p class="text-gray-600">Les données sont conservées aussi longtemps que nécessaire pour fournir nos services et respecter nos obligations légales.</p>

            <h2 class="font-semibold mt-4">5. Vos droits</h2>
            <p class="text-gray-600">Vous pouvez accéder, corriger ou demander la suppression de vos données. Pour exercer vos droits, contactez-nous à l'adresse indiquée ci-dessous.</p>

            <h2 class="font-semibold mt-4">6. Sécurité</h2>
            <p class="text-gray-600">Nous mettons en place des mesures de sécurité techniques et organisationnelles pour protéger vos données contre tout accès non autorisé.</p>

            <h2 class="font-semibold mt-4">7. Contact</h2>
            <p class="text-gray-600">Pour toute question relative à vos données personnelles, écrivez-nous : <a class="text-blue-600" href="mailto:benitoamedoume49@gmail.com">contact@unilome.com</a>.</p>

            <div class="mt-6">
                <a href="{{ url('/') }}" class="text-blue-600">Retour à l'accueil</a>
            </div>
            <p class="text-sm text-gray-500 mt-6">Dernière mise à jour : 31 janvier 2026</p>
        </div>
    </div>
</div>
@endsection
