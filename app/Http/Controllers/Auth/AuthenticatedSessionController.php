<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->discardExternalIntendedUrl($request);

        $defaultRedirect = $request->user()?->role?->isAdmin()
            ? route('admin.dashboard', absolute: false)
            : route('beranda', absolute: false);

        return redirect()->intended($defaultRedirect);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function discardExternalIntendedUrl(Request $request): void
    {
        $intended = $request->session()->get('url.intended');

        if (! is_string($intended) || $intended === '') {
            return;
        }

        if (str_starts_with($intended, '/') && ! str_starts_with($intended, '//') && ! str_starts_with($intended, '/\\')) {
            return;
        }

        $parsedHost = parse_url($intended, PHP_URL_HOST);
        $parsedScheme = parse_url($intended, PHP_URL_SCHEME);

        if ($parsedHost === $request->getHost() && in_array($parsedScheme, ['http', 'https'], true)) {
            return;
        }

        $request->session()->forget('url.intended');
    }
}
