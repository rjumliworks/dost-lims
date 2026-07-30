<?php

namespace App\Console\Commands;

use App\Models\UserCertificate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class EncryptCertificatePasswords extends Command
{
    protected $signature = 'certificates:encrypt-passwords';
    protected $description = 'Encrypt any plaintext PNPKI p12 passwords stored in user_certificates';

    public function handle()
    {
        $certificates = UserCertificate::whereNotNull('password')
            ->where('password', '!=', '')
            ->get();

        $encrypted = 0;
        $skipped = 0;

        foreach ($certificates as $certificate) {
            $raw = $certificate->getRawOriginal('password');

            try {
                // Already decrypts cleanly, so it's already encrypted.
                Crypt::decryptString($raw);
                $skipped++;
                continue;
            } catch (\Throwable $e) {
                // Not a valid encrypted payload, treat as legacy plaintext.
            }

            $certificate->password = $raw;
            $certificate->save();
            $encrypted++;
        }

        $this->info("Encrypted {$encrypted} password(s). Skipped {$skipped} already-encrypted password(s).");
    }
}
