<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestOrientation;
use App\Models\Question;
use App\Models\Reponse;

class TestOrientationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer le test
        $test = TestOrientation::create([
            'titre' => 'Test d\'orientation universitaire',
            'description' => 'Découvrez les formations qui vous correspondent le mieux grâce à ce test personnalisé',
            'duree_minutes' => 10,
            'nombre_questions' => 5,
            'est_actif' => true,
        ]);

        // 2. Créer les questions
        $questions = [
            [
                'texte' => 'Quel type d\'activités préférez-vous ?',
                'categorie' => 'interets',
                'reponses' => [
                    ['texte' => 'Lire, écrire, débattre', 'points' => ['lettres' => 3, 'droit' => 2]],
                    ['texte' => 'Résoudre des problèmes scientifiques', 'points' => ['sciences' => 3, 'ingenierie' => 2]],
                    ['texte' => 'Aider et soigner les autres', 'points' => ['medecine' => 3, 'lettres' => 1]],
                    ['texte' => 'Organiser, manager, vendre', 'points' => ['commerce' => 3, 'droit' => 1]],
                ]
            ],
            [
                'texte' => 'Dans quel environnement travaillez-vous le mieux ?',
                'categorie' => 'environnement',
                'reponses' => [
                    ['texte' => 'En laboratoire ou atelier', 'points' => ['sciences' => 2, 'ingenierie' => 3]],
                    ['texte' => 'Au contact des gens', 'points' => ['medecine' => 2, 'commerce' => 2]],
                    ['texte' => 'Devant un ordinateur', 'points' => ['ingenierie' => 2, 'sciences' => 1]],
                    ['texte' => 'En bibliothèque ou bureau calme', 'points' => ['lettres' => 3, 'droit' => 2]],
                ]
            ],
            [
                'texte' => 'Quelles matières préférez-vous à l\'école ?',
                'categorie' => 'competences',
                'reponses' => [
                    ['texte' => 'Mathématiques et physique', 'points' => ['sciences' => 3, 'ingenierie' => 3]],
                    ['texte' => 'Français et philosophie', 'points' => ['lettres' => 3, 'droit' => 2]],
                    ['texte' => 'Sciences de la vie', 'points' => ['medecine' => 3, 'sciences' => 2]],
                    ['texte' => 'Économie et gestion', 'points' => ['commerce' => 3, 'droit' => 1]],
                ]
            ],
            [
                'texte' => 'Quel est votre projet professionnel idéal ?',
                'categorie' => 'projet',
                'reponses' => [
                    ['texte' => 'Chercheur ou ingénieur', 'points' => ['sciences' => 3, 'ingenierie' => 3]],
                    ['texte' => 'Médecin ou profession de santé', 'points' => ['medecine' => 3]],
                    ['texte' => 'Avocat ou juriste', 'points' => ['droit' => 3]],
                    ['texte' => 'Écrivain ou enseignant', 'points' => ['lettres' => 3]],
                    ['texte' => 'Entrepreneur ou manager', 'points' => ['commerce' => 3]],
                ]
            ],
            [
                'texte' => 'Comment aimez-vous travailler ?',
                'categorie' => 'methode',
                'reponses' => [
                    ['texte' => 'En équipe, en collaborant', 'points' => ['commerce' => 2, 'medecine' => 1]],
                    ['texte' => 'Seul, en approfondissant', 'points' => ['sciences' => 2, 'lettres' => 2]],
                    ['texte' => 'En plaidant, en argumentant', 'points' => ['droit' => 3]],
                    ['texte' => 'En créant, en innovant', 'points' => ['ingenierie' => 2, 'lettres' => 1]],
                ]
            ],
        ];

        // 3. Créer questions et réponses
        foreach ($questions as $index => $questionData) {
            $question = Question::create([
                'test_id' => $test->id,
                'texte' => $questionData['texte'],
                'categorie' => $questionData['categorie'],
                'ordre' => $index + 1,
            ]);

            foreach ($questionData['reponses'] as $ordre => $reponseData) {
                Reponse::create([
                    'question_id' => $question->id,
                    'texte' => $reponseData['texte'],
                    'points' => json_encode($reponseData['points']),
                    'ordre' => $ordre + 1,
                ]);
            }
        }

        $this->command->info('✅ Test d\'orientation créé avec ' . count($questions) . ' questions');
    }
}