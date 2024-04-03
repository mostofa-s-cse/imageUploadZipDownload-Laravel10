<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; // Updated namespace
use ZipArchive;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,pdf|max:2048' // adjust file size limit as needed
        ]);

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path() . '/uploads/', $name);
                Image::create(['filename' => $name]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    public function download()
    {
        $images = Image::all();
        $zip = new ZipArchive;
        $fileName = 'images.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($images as $image) {
                $zip->addFile(public_path('uploads/' . $image->filename), $image->filename);
            }
            $zip->close();
        }

        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }

    public function singleDownload($id)
        {
            $image = Image::find($id);

            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            $zip = new ZipArchive;
            $fileName = 'image_' . $id . '.zip';

            if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
                $zip->addFile(public_path('uploads/' . $image->filename), $image->filename);
                $zip->close();
            } else {
                return response()->json(['error' => 'Unable to create zip archive'], 500);
            }

            // Specify appropriate MIME type for the response
            return response()->download($fileName, $image->filename . '.zip', ['Content-Type' => 'application/zip'])
                ->deleteFileAfterSend(true);
        }

}
