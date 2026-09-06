<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\CollaborationInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollaborationAdminController extends Controller
{
    /**
     * Display a listing of collaboration inquiries and collaboration tracks.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'inquiries');
        $statusFilter = $request->query('status', 'all');
        $search = $request->query('search');

        $query = CollaborationInquiry::latest('id');

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(12)->withQueryString();

        // Statistics
        $totalInquiries = CollaborationInquiry::count();
        $unreadCount = CollaborationInquiry::unread()->count();
        $newCount = CollaborationInquiry::where('status', 'baru')->count();
        $reviewCount = CollaborationInquiry::where('status', 'ditinjau')->count();
        $contactedCount = CollaborationInquiry::where('status', 'dihubungi')->count();
        $doneCount = CollaborationInquiry::where('status', 'selesai')->count();

        $collaborations = Collaboration::ordered()->get();

        return view('admin.collaborations.index', [
            'activeTab' => $activeTab,
            'collaborations' => $collaborations,
            'inquiries' => $inquiries,
            'statusFilter' => $statusFilter,
            'search' => $search,
            'totalInquiries' => $totalInquiries,
            'unreadCount' => $unreadCount,
            'newCount' => $newCount,
            'reviewCount' => $reviewCount,
            'contactedCount' => $contactedCount,
            'doneCount' => $doneCount,
        ]);
    }

    /**
     * Show the form for editing the specified collaboration track.
     */
    public function edit(Collaboration $collaboration): View
    {
        return view('admin.collaborations.edit', [
            'collaboration' => $collaboration,
        ]);
    }

    /**
     * Update the specified collaboration track.
     */
    public function update(Request $request, Collaboration $collaboration): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'badge_id' => ['nullable', 'string', 'max:255'],
            'badge_en' => ['nullable', 'string', 'max:255'],
            'subtitle_id' => ['nullable', 'string'],
            'subtitle_en' => ['nullable', 'string'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'terms_id_raw' => ['nullable', 'string'],
            'terms_en_raw' => ['nullable', 'string'],
            'requirements_id_raw' => ['nullable', 'string'],
            'requirements_en_raw' => ['nullable', 'string'],
            'email_to' => ['required', 'email', 'max:255'],
            'email_subject' => ['nullable', 'string', 'max:255'],
            'email_template' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Process line-by-line arrays for terms and requirements
        if ($request->has('terms_id_raw')) {
            $validated['terms_id'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('terms_id_raw', '')))));
        }
        if ($request->has('terms_en_raw')) {
            $validated['terms_en'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('terms_en_raw', '')))));
        }
        if ($request->has('requirements_id_raw')) {
            $validated['requirements_id'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('requirements_id_raw', '')))));
        }
        if ($request->has('requirements_en_raw')) {
            $validated['requirements_en'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('requirements_en_raw', '')))));
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        unset(
            $validated['terms_id_raw'],
            $validated['terms_en_raw'],
            $validated['requirements_id_raw'],
            $validated['requirements_en_raw']
        );

        $collaboration->update($validated);

        return redirect()->route('admin.collaborations.index', ['tab' => 'tracks'])
            ->with('status', "Program kolaborasi '{$collaboration->title_id}' berhasil diperbarui!");
    }

    /**
     * Get detail of a specific inquiry as JSON.
     */
    public function showInquiry(CollaborationInquiry $inquiry): JsonResponse
    {
        if (empty($inquiry->read_at)) {
            $inquiry->update(['read_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'inquiry' => $inquiry,
            'whatsapp_url' => $inquiry->whatsapp_url,
            'created_at_formatted' => $inquiry->created_at->translatedFormat('d F Y, H:i WIB'),
        ]);
    }

    /**
     * Update status and notes of an inquiry.
     */
    public function updateInquiry(Request $request, CollaborationInquiry $inquiry): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:baru,ditinjau,dihubungi,selesai,arsip'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($validated['status'] !== 'baru' && empty($inquiry->read_at)) {
            $validated['read_at'] = now();
        }

        $inquiry->update($validated);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesan kolaborasi berhasil diperbarui.',
                'inquiry' => $inquiry,
            ]);
        }

        return redirect()->route('admin.collaborations.index', ['tab' => 'inquiries'])
            ->with('status', 'Status pesan kolaborasi berhasil diperbarui.');
    }

    /**
     * Toggle read/unread state of an inquiry.
     */
    public function toggleReadInquiry(CollaborationInquiry $inquiry): RedirectResponse|JsonResponse
    {
        $inquiry->update([
            'read_at' => $inquiry->read_at ? null : now(),
        ]);

        return redirect()->route('admin.collaborations.index', ['tab' => 'inquiries'])
            ->with('status', 'Status baca pesan berhasil diperbarui.');
    }

    /**
     * Delete an inquiry from database.
     */
    public function destroyInquiry(CollaborationInquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()->route('admin.collaborations.index', ['tab' => 'inquiries'])
            ->with('status', 'Pesan formulir kolaborasi berhasil dihapus.');
    }
}
