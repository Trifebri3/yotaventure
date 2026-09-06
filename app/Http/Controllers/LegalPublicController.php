<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalPublicController extends Controller
{
    /**
     * Display the official Terms and Conditions (Syarat dan Ketentuan).
     */
    public function terms(): View
    {
        return view('public.legal.terms');
    }

    /**
     * Display the official Privacy Policy (Kebijakan Privasi - UU No. 27/2022 PDP).
     */
    public function privacy(): View
    {
        return view('public.legal.privacy');
    }

    /**
     * Display the official Information Security Policy (Keamanan Informasi - ISO/IEC 27001).
     */
    public function security(): View
    {
        return view('public.legal.security');
    }
}
