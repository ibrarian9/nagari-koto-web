<?php

namespace App\Http\Middleware;

use App\Models\SiteVisitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful or redirecting GET requests on public pages
        if ($this->shouldTrack($request, $response)) {
            $this->track($request);
        }

        return $response;
    }

    /**
     * Determine whether this request should be tracked as a site visit.
     */
    protected function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        // Only track 200 OK responses (ignore 404, 500, etc.)
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        // Bypass internal, admin, utility, and static asset routes
        if ($request->is([
            'livewire/*',
            'admin*',
            'admin/*',
            'up',
            '_debugbar*',
            'storage/*',
            'build/*',
            'favicon.ico',
            'robots.txt',
        ])) {
            return false;
        }

        return true;
    }

    /**
     * Record or update the site visitor record for the current session and date.
     */
    protected function track(Request $request): void
    {
        try {
            $sessionId = $request->hasSession() && $request->session()->getId()
                ? $request->session()->getId()
                : md5($request->ip() . '|' . (string) $request->userAgent());

            $today = today()->toDateString();
            $now = now();

            $visitor = SiteVisitor::firstOrNew([
                'session_id' => $sessionId,
                'visit_date' => $today,
            ]);

            if (! $visitor->exists) {
                $visitor->ip_address = $request->ip();
                $visitor->user_agent = substr((string) $request->userAgent(), 0, 500);
                $visitor->hits = 1;
                $visitor->last_activity = $now;
                $visitor->save();
            } else {
                $visitor->increment('hits', 1, [
                    'last_activity' => $now,
                ]);
            }
        } catch (\Throwable $e) {
            // Fail silently so visitor tracking never disrupts page rendering
            report($e);
        }
    }
}
