<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TestOrientation;
use App\Models\Question;
use App\Models\Reponse;

class FixTestData extends Command
{
    protected $signature = 'test:fix';
    protected $description = 'Corriger les données du test d\'orientation';

    public function handle()
    {
        $this->info('🧹 Nettoyage des anciennes données...');
        
        // Supprimer dans le bon ordre (à cause des clés étrangères)
        Reponse::query()->delete();
        Question::query()->delete();
        TestOrientation::query()->delete();
        
        $this->info('✅ Données supprimées');
        
        // Créer un nouveau test
        $test = TestOrientation::create([
            'titre' => 'Test d\'orientation - Découvrez votre voie',
            'description' => 'Répondez à 5 questions simples pour découvrir les formations qui vous correspondent',
            'duree_minutes' => 5,
            'nombre_questions' => 5,
            'est_actif' => true,
        ]);
        
        $this->info("✅ Test créé (ID: {$test->id})");
        
        // Questions avec réponses
        $questions = [
            [
                'texte' => 'Quel type d\'activités vous passionne ?',
                'categorie' => 'passions',
                'reponses' => [
                    ['texte' => 'Lire, écrire, analyser des textes', 'points' => ['lettres' => 3, 'droit' => 2]],
                    ['texte' => 'Expérimenter, découvrir, comprendre la nature', 'points' => ['sciences' => 3, 'medecine' => 2]],
                    ['texte' => 'Créer, construire, inventer', 'points' => ['ingenierie' => 3, 'commerce' => 1]],
                    ['texte' => 'Aider, soigner, écouter', 'points' => ['medecine' => 3, 'lettres' => 1]],
                ]
            ],
            [
                'texte' => 'Dans quel environnement travaillez-vous le mieux ?',
                'categorie' => 'environnement',
                'reponses' => [
                    ['texte' => 'Calme, bureau ou bibliothèque', 'points' => ['lettres' => 2, 'droit' => 2]],
                    ['texte' => 'Laboratoire avec équipements', 'points' => ['sciences' => 3, 'ingenierie' => 2]],
                    ['texte' => 'Au contact des gens (hôpital, entreprise)', 'points' => ['medecine' => 2, 'commerce' => 2]],
                    ['texte' => 'En équipe, en collaboration', 'points' => ['commerce' => 2, 'ingenierie' => 1]],
                ]
            ],
            [
                'texte' => 'Quelles matières aimiez-vous à l\'école ?',
                'categorie' => 'scolaire',
                'reponses' => [
                    ['texte' => 'Mathématiques et physique', 'points' => ['sciences' => 3, 'ingenierie' => 3]],
                    ['texte' => 'Français et langues', 'points' => ['lettres' => 3, 'droit' => 2]],
                    ['texte' => 'Sciences de la vie', 'points' => ['medecine' => 3, 'sciences' => 2]],
                    ['texte' => 'Économie et gestion', 'points' => ['commerce' => 3, 'droit' => 1]],
                ]
            ],
            [
                'texte' => 'Quel est votre projet professionnel idéal ?',
                'categorie' => 'projet',
                'reponses' => [
                    ['texte' => 'Chercheur ou scientifique', 'points' => ['sciences' => 3]],
                    ['texte' => 'Médecin ou profession de santé', 'points' => ['medecine' => 3]],
                    ['texte' => 'Ingénieur ou technicien', 'points' => ['ingenierie' => 3]],
                    ['texte' => 'Avocat ou juriste', 'points' => ['droit' => 3]],
                    ['texte' => 'Écrivain ou enseignant', 'points' => ['lettres' => 3]],
                    ['texte' => 'Entrepreneur ou manager', 'points' => ['commerce' => 3]],
                ]
            ],
            [
                'texte' => 'Comment abordez-vous les problèmes ?',
                'categorie' => 'methodologie',
                'reponses' => [
                    ['texte' => 'Par la logique et l\'analyse', 'points' => ['sciences' => 2, 'ingenierie' => 2]],
                    ['texte' => 'Par la discussion et l\'argumentation', 'points' => ['droit' => 3, 'commerce' => 1]],
                    ['texte' => 'Par la créativité et l\'innovation', 'points' => ['lettres' => 2, 'ingenierie' => 1]],
                    ['texte' => 'Par l\'empathie et la compréhension', 'points' => ['medecine' => 2, 'lettres' => 1]],
                ]
            ],
        ];
        
        // Créer questions et réponses
        foreach ($questions as $index => $qData) {
            $question = Question::create([
                'test_id' => $test->id,
                'texte' => $qData['texte'],
                'categorie' => $qData['categorie'],
                'ordre' => $index + 1,
            ]);
            
            $this->info("  📝 Question {$question->id} créée");
            
            foreach ($qData['reponses'] as $ordre => $rData) {
                $reponse = Reponse::create([
                    'question_id' => $question->id,  // ⭐⭐ IMPORTANT : question_id correct ⭐⭐
                    'texte' => $rData['texte'],
                    'points' => json_encode($rData['points']),
                    'ordre' => $ordre + 1,
                ]);
                
                $this->info("    • Réponse {$reponse->id} pour question {$question->id}");
            }
        }
        
        // Vérification finale
        $totalQuestions = Question::count();
        $totalReponses = Reponse::count();
        $reponsesParQuestion = Reponse::groupBy('question_id')->selectRaw('question_id, count(*) as count')->get();
        
        $this->info("\n✅ VÉRIFICATION FINALE");
        $this->info("Total questions: {$totalQuestions}");
        $this->info("Total réponses: {$totalReponses}");
        
        foreach ($reponsesParQuestion as $r) {
            $this->info("Question {$r->question_id}: {$r->count} réponses");
        }
        
        $this->info("\n🎉 Données corrigées avec succès !");
        $this->info("Testez: http://localhost:8000/test-orientation");
    }
}