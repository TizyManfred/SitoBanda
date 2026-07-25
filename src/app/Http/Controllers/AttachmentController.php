<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentController extends Controller
{
    public function __invoke(Attachment $attachment): StreamedResponse
    {
        abort_unless(
            $attachment->isPubliclyAvailable()
            && Storage::disk($attachment->disk)->exists($attachment->file_path),
            404
        );

        $extension = strtolower($attachment->extension());
        $filename = Str::slug($attachment->displayTitle()) ?: 'document';

        if ($extension !== '') {
            $filename .= ".{$extension}";
        }

        return Storage::disk($attachment->disk)->download(
            $attachment->file_path,
            $filename,
            ['Content-Type' => $attachment->mime_type ?: 'application/octet-stream']
        );
    }
}
