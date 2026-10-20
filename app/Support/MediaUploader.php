<?php

namespace App\Support;

use App\Models\ProductMedia;
use App\Models\ProductSubmissionMedia;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Helper kecil untuk menyimpan/menghapus foto dan video produk
 * di disk "public" (storage/app/public -> diakses lewat /storage).
 */
class MediaUploader
{
    /**
     * @param  UploadedFile[]  $photos
     * @return array<int, array{media_type: string, file_path: string}>
     */
    public static function store(array $photos, ?UploadedFile $video, string $dir): array
    {
        $items = [];

        foreach ($photos as $photo) {
            $items[] = [
                'media_type' => 'image',
                'file_path'  => $photo->store($dir, 'public'),
            ];
        }

        if ($video) {
            $items[] = [
                'media_type' => 'video',
                'file_path'  => $video->store($dir, 'public'),
            ];
        }

        return $items;
    }

    /**
     * Hapus file dari disk hanya jika sudah tidak dipakai baris database mana pun.
     * (Saat admin menyetujui pengajuan, file yang sama dipakai product_media
     *  dan product_submission_media, jadi tidak boleh asal dihapus.)
     *
     * @param  string[]  $paths
     */
    public static function deleteUnused(array $paths): void
    {
        foreach (array_unique($paths) as $path) {
            $dipakai = ProductMedia::where('file_path', $path)->exists()
                || ProductSubmissionMedia::where('file_path', $path)->exists();

            if (! $dipakai) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
