<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Demande;
use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Upload; 
use Illuminate\Support\Facades\DB;

use \App\Models\User;
class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $demande = Demande::with('users')->findOrFail($id);

        $usersDurations = $demande->usersWithDurations();

        $qrcode = base64_encode(QrCode::format('png')->size(150)->generate(route('demande', $id)));

        $data = [
            'demande' => $demande,
            'usersDurations' => $usersDurations,
            'qrcode' => $qrcode,
        ];

        $pdf = PDF::loadView('admin.demandes.pdf', $data);

        return $pdf->download('demande_' . $id . '.pdf');
    }
    

    
    public function downloadPdf($id)
    {
        $demande = Demande::findOrFail($id);
        $usersDurations = $demande->usersWithDurations();
        $qrcode = base64_encode(QrCode::format('png')->size(150)->generate(route('demande', $id)));
        
        $data = [
            'demande' => $demande,
            'usersDurations' => $usersDurations,
            'qrcode' => $qrcode,
        ];

        $pdf = PDF::loadView('admin.demandes.pdf', $data);
        
        return $pdf->download('demande_' . $id . '.pdf');
    }

    public function showUserUploads($demandeId, $userId)
    {
        $demande = Demande::findOrFail($demandeId);
        $user = User::findOrFail($userId);
        
        $isAssigned = $demande->users()->where('user_id', $userId)->exists();
        $fichiers = DB::table('demande_files')
        ->where('demande_id',$demandeId)
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($fichiers);
        if (!$isAssigned) {
            abort(404, 'Cet utilisateur n\'est pas affecté à cette demande.');
        }
        return view('admin.demandes.user-uploads', compact('demande', 'user', 'fichiers'));
    }
    public function download($demande, $user, $fichier)
{
    // On récupère l'enregistrement de la table demande_files
    $file = DB::table('demande_files')
        ->where('id', $fichier)
        ->where('demande_id', $demande)
        ->where('user_id', $user)
        ->first();

    if (!$file) {
        abort(404, 'Fichier introuvable dans la base de données.');
    }

    $filePath = $file->file_path;

    if (!\Storage::disk('public')->exists($filePath)) {
        abort(404, 'Fichier introuvable sur le disque.');
    }

    return \Storage::disk('public')->download($filePath, basename($filePath));
}


}