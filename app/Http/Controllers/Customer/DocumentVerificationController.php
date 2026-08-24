<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DocumentVerificationController extends Controller
{
    public function index()
    {
        return inertia('Customer/VerifyDocument/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:20480',
        ]);

        $pdf = $request->file('pdf');

        $response = Http::attach(
            'file',
            file_get_contents($pdf->getRealPath()),
            $pdf->getClientOriginalName()
        )->post('http://127.0.0.1:8000/verify');

        if (!$response->successful()) {
            return back()->with([
                'data' => null,
                'message' => 'Verification failed',
                'info' => $response->json('message') ?? 'The verification service could not be reached.',
                'status' => false,
            ]);
        }

        return back()->with([
            'data' => $response->json(),
            'message' => 'Document checked.',
            'info' => 'The document has been analyzed.',
            'status' => true,
        ]);
    }
}
