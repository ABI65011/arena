<?php

// meow meow meow

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gates the student-facing routes that assume an applicant record already
 * exists (My Applications, My Profile). The Apply route is deliberately
 * NOT behind this middleware, since it's what creates that record in the
 * first place — see routes file for the split.
 */
class EnsureUserIsApplicant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isStudent()) {
            return redirect()->route('apply')
                ->with('error', 'Please complete your application details first.');
        }

        return $next($request);
    }
}
