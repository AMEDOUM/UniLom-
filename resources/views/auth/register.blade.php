@extends('layouts.app')


@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo et titre -->
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-user-plus text-blue-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créer votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Choisissez votre type de compte
            </p>
        </div>

        <!-- Sélecteur de rôle -->
        <div class="flex space-x-4 mb-6" id="role-selector">
            <button type="button" data-role="etudiant" 
                    class="role-option flex-1 p-4 border-2 rounded-lg text-center transition-all duration-200 hover:border-blue-300 hover:bg-blue-50">
                <div class="text-blue-600 text-2xl mb-2">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="font-bold text-gray-800">Étudiant</div>
                <div class="text-sm text-gray-500 mt-1">Chercher une formation</div>
            </button>
            
            <button type="button" data-role="universite" 
                    class="role-option flex-1 p-4 border-2 rounded-lg text-center transition-all duration-200 hover:border-purple-300 hover:bg-purple-50">
                <div class="text-purple-600 text-2xl mb-2">
                    <i class="fas fa-university"></i>
                </div>
                <div class="font-bold text-gray-800">Université</div>
                <div class="text-sm text-gray-500 mt-1">Promouvoir vos formations</div>
            </button>
        </div>

        <!-- Formulaire -->
        <form id="register-form" class="mt-8 space-y-6" action="{{ route('register.store') }}" method="POST">
            @csrf
            
            <!-- Champ caché pour le rôle -->
            <input type="hidden" name="role" id="role" value="etudiant">
            
            <!-- Champs communs -->
            <div class="space-y-4">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                    <input id="nom" name="nom" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Votre nom et prénom">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="exemple@email.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe *</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Minimum 8 caractères">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe *</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Retapez votre mot de passe">
                </div>
            </div>

            <!-- Champs spécifiques Étudiant -->
            <div id="etudiant-fields" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input id="date_naissance" name="date_naissance" type="date" 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="sexe" class="block text-sm font-medium text-gray-700">Sexe</label>
                        <select id="sexe" name="sexe" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Sélectionner</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Champs spécifiques Université -->
            <div id="universite-fields" class="space-y-4 hidden">
                <div>
                    <label for="nom_universite" class="block text-sm font-medium text-gray-700">Nom de l'université *</label>
                    <input id="nom_universite" name="nom_universite" type="text" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Ex: Université de Lomé">
                </div>
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input id="telephone" name="telephone" type="text" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="(+228) XX XX XX XX">
                </div>
                <div>
                    <label for="localisation" class="block text-sm font-medium text-gray-700">Localisation</label>
                    <input id="localisation" name="localisation" type="text" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Lomé, Togo">
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Votre compte université sera validé par un administrateur dans les 24h.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Politique de confidentialité -->
            <div class="flex items-start mb-4">
                <div class="flex items-center h-5">
                    <input id="privacy" name="privacy" type="checkbox" required class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="privacy" class="font-medium text-gray-700">J'accepte la <a href="{{ route('privacy') }}" target="_blank" class="text-blue-600 hover:text-blue-800">politique de confidentialité</a></label>
                </div>
            </div>

            <!-- Bouton d'inscription -->
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Créer mon compte
                </button>
            </div>
            
            <!-- Lien connexion -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Déjà un compte ? Connectez-vous
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.role-option.active {
    border-color: #3b82f6;
    background-color: #eff6ff;
}
.role-option[data-role="universite"].active {
    border-color: #8b5cf6;
    background-color: #f5f3ff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleOptions = document.querySelectorAll('.role-option');
    const roleField = document.getElementById('role');
    const etudiantFields = document.getElementById('etudiant-fields');
    const universiteFields = document.getElementById('universite-fields');
    const nomUniversiteField = document.getElementById('nom_universite');
    
    function setActiveRole(role) {
        // Mettre à jour le champ caché
        roleField.value = role;
        
        // Mettre à jour l'apparence des boutons
        roleOptions.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.role === role) {
                btn.classList.add('active');
            }
        });
        
        // Afficher/masquer les champs spécifiques
        if (role === 'etudiant') {
            etudiantFields.classList.remove('hidden');
            universiteFields.classList.add('hidden');
        } else {
            etudiantFields.classList.add('hidden');
            universiteFields.classList.remove('hidden');
        }
    }
    
    // Événements sur les boutons de rôle
    roleOptions.forEach(btn => {
        btn.addEventListener('click', () => {
            setActiveRole(btn.dataset.role);
        });
    });
    
    // Activer étudiant par défaut
    setActiveRole('etudiant');
    
    // Validation côté client pour les universités
    document.getElementById('register-form').addEventListener('submit', function(e) {
        if (roleField.value === 'universite') {
            if (!nomUniversiteField.value.trim()) {
                e.preventDefault();
                alert('Veuillez saisir le nom de votre université');
                nomUniversiteField.focus();
            }
        }
    });
});
</script>
@endsection