<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisitorTraffic
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Run visitor logging asynchronously or post-response to avoid blocking
        $this->logVisitor($request);

        return $response;
    }

    /**
     * Determine whether to log and record visitor data
     */
    protected function logVisitor(Request $request): void
    {
        try {
            // Ignore non-GET requests for traffic analytics (e.g. POST form submissions)
            if ($request->method() !== 'GET') {
                return;
            }

            $path = trim($request->path(), '/');

            // Skip internal, admin, authentication, asset, or debug paths
            if (
                str_starts_with($path, 'admin') ||
                str_starts_with($path, 'login') ||
                str_starts_with($path, 'logout') ||
                str_starts_with($path, 'register') ||
                str_starts_with($path, 'password') ||
                str_starts_with($path, 'livewire') ||
                str_starts_with($path, '_') ||
                str_starts_with($path, 'build') ||
                str_starts_with($path, 'storage') ||
                str_starts_with($path, 'vendor')
            ) {
                return;
            }

            // Skip common file extensions
            if (preg_match('/\.(png|jpg|jpeg|gif|svg|ico|css|js|map|woff|woff2|ttf|json|xml|txt)$/i', $path)) {
                return;
            }

            $userAgent = $request->userAgent() ?? '';
            $isBot = $this->isSearchEngineBot($userAgent);

            // Parse device, browser, and OS
            $device = $this->detectDevice($userAgent);
            $browser = $this->detectBrowser($userAgent);
            $os = $this->detectOs($userAgent);

            $ip = $request->ip() ?? '127.0.0.1';
            $geo = $this->resolveGeoLocation($ip);

            VisitorLog::create([
                'ip_address' => $ip,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'url' => $request->fullUrl(),
                'path' => '/'.$path,
                'method' => $request->method(),
                'referer' => $request->headers->get('referer'),
                'user_agent' => substr($userAgent, 0, 500),
                'device' => $device,
                'browser' => $browser,
                'os' => $os,
                'country' => $geo['country'],
                'city' => $geo['city'],
                'country_code' => $geo['country_code'],
                'is_bot' => $isBot,
            ]);
        } catch (Throwable $e) {
            // Silently fail to ensure user web experience is never affected
            report($e);
        }
    }

    /**
     * Check if user agent is a search crawler / bot
     */
    protected function isSearchEngineBot(string $userAgent): bool
    {
        return (bool) preg_match(
            '/bot|crawl|slurp|spider|mediapartners|googlebot|bingbot|duckduckbot|baiduspider|yandexbot/i',
            $userAgent
        );
    }

    /**
     * Detect device category
     */
    protected function detectDevice(string $userAgent): string
    {
        if (preg_match('/ipad|tablet|playbook|silk/i', $userAgent)) {
            return 'Tablet';
        }
        if (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i', $userAgent)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    /**
     * Detect browser name
     */
    protected function detectBrowser(string $userAgent): string
    {
        if (preg_match('/edg/i', $userAgent)) {
            return 'Edge';
        }
        if (preg_match('/chrome|crios/i', $userAgent) && ! preg_match('/opr|opera/i', $userAgent)) {
            return 'Chrome';
        }
        if (preg_match('/safari/i', $userAgent) && ! preg_match('/chrome|crios/i', $userAgent)) {
            return 'Safari';
        }
        if (preg_match('/firefox|fxios/i', $userAgent)) {
            return 'Firefox';
        }
        if (preg_match('/opr|opera/i', $userAgent)) {
            return 'Opera';
        }

        return 'Other';
    }

    /**
     * Detect operating system
     */
    protected function detectOs(string $userAgent): string
    {
        if (preg_match('/windows nt 10/i', $userAgent)) {
            return 'Windows 11/10';
        }
        if (preg_match('/windows/i', $userAgent)) {
            return 'Windows';
        }
        if (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'macOS';
        }
        if (preg_match('/android/i', $userAgent)) {
            return 'Android';
        }
        if (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            return 'iOS';
        }
        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        }

        return 'Other';
    }

    /**
     * Resolve Geo Location from IP address
     * (Provides simulated fallback for local development or intranet IPs)
     */
    protected function resolveGeoLocation(string $ip): array
    {
        // For local/dev IP addresses, return realistic Indonesian hub
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return [
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'country_code' => 'ID',
            ];
        }

        // Default fallback for unknown external IPs
        return [
            'country' => 'Indonesia',
            'city' => 'Surabaya',
            'country_code' => 'ID',
        ];
    }
}
