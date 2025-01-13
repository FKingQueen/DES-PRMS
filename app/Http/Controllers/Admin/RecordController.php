<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Document;
use App\Models\User;

class RecordController extends Controller
{
    public function uploadRecordDocument(Request $request){
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');

            // Use the original filename and append the authenticated user's name
            $user = User::find($request->id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . ' - ' . $user->name . '.' . $file->getClientOriginalExtension();

            $directory = 'records/';
            $file->move(public_path($directory), $filename);

            $newDocumentFiles = new Document;
            $newDocumentFiles->user_id = $request->id;
            $newDocumentFiles->fileName = $filename;
            $newDocumentFiles->save();

            return response()->json([
                'status' => 'success',
                'path' => asset($directory . $filename),
                'filename' => $filename,
                'id' => $newDocumentFiles->id,
                // 'document_file_id' => $newDocumentFiles->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File upload failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getDocuments(){
        try {
            return User::whereHas('document')->orderBy('id', 'desc')->with('document')->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve documents', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteRecordDocument(Request $request){
        try {
            $document = Document::find($request->id);
            if (!$document) {
                return response()->json(['error' => 'Document not found'], 404);
            }

            $fileName = $document->fileName;
            $filePath = public_path('records/' . $fileName);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            $document->delete();

            return response()->json(['status' => 'success', 'message' => 'Document deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete document', 'message' => $e->getMessage()], 500);
        }
    }

    public function downloadDocument($id){
        try {
            $document = Document::find($id);
            if (!$document) {
                return response()->json(['error' => 'Document not found'], 404);
            }

            $filePath = public_path('records/' . $document->fileName);
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            return response()->download($filePath, $document->fileName);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to download document', 'message' => $e->getMessage()], 500);
        }
    }

    public function searchArticle(Request $request){
        try {
            $documents = Document::where('fileName', 'LIKE', "%{$request->search}%")
                ->where('user_id', auth()->id())
                ->orderBy('created_at')
                ->with('user')
                ->get();
            return response()->json($documents);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search documents', 'message' => $e->getMessage()], 500);
        }
    }
}
