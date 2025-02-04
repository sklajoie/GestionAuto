<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicules;
use App\Models\Versements;
use Illuminate\Support\Facades\Mail;

class SendMonthlyReport extends Command
{
    protected $signature = 'report:monthly';
    protected $description = 'Envoie un rapport mensuel des véhicules et versements';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Sélection des données des véhicules
        $vehicule = Vehicules::select('Matriculation', 'Marque', 'Model', 'Type')
            ->where('supprimer', 0)
            ->first();

        // Sélection des données des versements
        $rapport = Versements::select('Montant', 'MoyenPaiemet', 'Reference', 'Rubrique', 'date', 'Mouvement', 'Beneficier', 'conducteur_id', 'vehicule_id', 'user_id')
            ->where('supprimer', 0)
            ->get();

        $dataByMonth = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];
        foreach ($rapport as $rappor) {
            $month = date('Y-m', strtotime($rappor->date));
            $dataByMonth[$month][] = $rappor;
            $mouvement = $rappor->Mouvement;

            if (!isset($totalByMouvement[$month])) {
                $totalByMouvement[$month] = 0;
            }
            if (!isset($totalByMouvementstr[$month])) {
                $totalByMouvementstr[$month] = 0;
            }

            if ($mouvement == "ENTREE EN CAISSE") {
                $totalByMouvement[$month] += $rappor->Montant;
            } elseif ($mouvement == "SORTIE DE CAISSE") {
                $totalByMouvementstr[$month] += $rappor->Montant;
            }
        }

        // Composition du rapport en texte
        $report = "Rapport mensuel des véhicules et versements\n\n";
        foreach ($dataByMonth as $month => $reports) {
            $report .= "Mois: $month\n";
            foreach ($reports as $r) {
                $report .= "Montant: {$r->Montant}, MoyenPaiemet: {$r->MoyenPaiemet}, Référence: {$r->Reference}, Rubrique: {$r->Rubrique}, Date: {$r->date}, Mouvement: {$r->Mouvement}, Bénéficier: {$r->Beneficier}\n";
            }
            $report .= "Total Entrée: " . $totalByMouvement[$month] . "\n";
            $report .= "Total Sortie: " . $totalByMouvementstr[$month] . "\n\n";
        }

        // Envoi du rapport par e-mail
        Mail::raw($report, function ($message) {
            $message->from('kigninnama@gmail.com', 'Nom de l\'expéditeur');
            $message->to('kigninnama@gmail.com', 'Nom du destinataire');
            $message->subject('Rapport mensuel des véhicules et versements');
        });

        $this->info('Le rapport a été envoyé avec succès');
    }
}
