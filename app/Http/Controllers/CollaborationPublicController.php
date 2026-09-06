<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\CollaborationInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollaborationPublicController extends Controller
{
    /**
     * Display the comprehensive collaboration hub with tabs for all 6 tracks.
     */
    public function index(Request $request): View
    {
        $collaborations = Collaboration::active()->ordered()->get();
        $selectedSlug = $request->query('track', $collaborations->first()?->slug ?? 'kemitraan');

        return view('public.kolaborasi.index', [
            'collaborations' => $collaborations,
            'selectedSlug' => $selectedSlug,
        ]);
    }

    /**
     * Redirect or direct view for a specific collaboration track.
     */
    public function show(string $slug)
    {
        $collaboration = Collaboration::active()->where('slug', $slug)->firstOrFail();

        return redirect()->route('public.collaboration.index', ['track' => $collaboration->slug]);
    }

    /**
     * Store incoming collaboration inquiry from the public form.
     */
    public function storeInquiry(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $validated['status'] = 'baru';

        $inquiry = CollaborationInquiry::create($validated);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan kolaborasi Anda berhasil diterima! Tim Kemitraan Strategis YOIN akan meninjau dan merespons pesan Anda dalam 1x24 jam kerja.',
                'inquiry_id' => $inquiry->id,
            ]);
        }

        return back()->with('collaboration_success', true);
    }
}
