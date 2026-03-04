<?php

namespace App\Http\Controllers\Public;

use setasign\Fpdi\Tcpdf\Fpdi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function pnpki(){
        $p12Path = storage_path('app/public/profile-p12/rij.p12');
        if (!file_exists($p12Path)) {
            return response()->json(['error' => 'P12 file not found']);
        }
        $p12 = file_get_contents($p12Path);
        $password = 'KKradsbg44';

        if (!openssl_pkcs12_read($p12, $certs, $password)) {
            return response()->json(['error' => 'Invalid certificate password']);
        }

         return response()->json([
            'status' => 'Certificate Loaded Successfully',
            'subject' => openssl_x509_parse($certs['cert'])['subject']
        ]);

    }

    public function verification()
    {
        return inertia('Public/Verification/Index', [
            'result' => null
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $content = file_get_contents($request->file('file')->getRealPath());
        $secret = config('app.key');

        // Extract HMAC
        if (!preg_match('/% ValidationHMAC:\s*([a-f0-9]{64})/i', $content, $m)) {
            return inertia('Public/Verification/Index', [
                'result' => [
                    'status' => 'missing',
                    'message' => '⚠️ Missing validation metadata.',
                ],
            ]);
        }

        $embedded = $m[1];

        // Remove metadata, but keep final %%EOF untouched
        $clean = preg_replace('/\n%--- DOC META ---.*?%--- END META ---\n(?=%%EOF)/s', '', $content, 1);

        // Recompute HMAC
        $recomputed = hash_hmac('sha256', $clean, $secret);

        $match = hash_equals($embedded, $recomputed);

        return response()->json([
            'status'     => $match ? 'valid' : 'tampered',
            'message'    => $match
                ? '✅ Verified — the uploaded document is authentic.'
                : '❌ Tampered — the document has been altered.',
            'embedded'   => $embedded,
            'recomputed' => $recomputed,
        ]);
    }
}
