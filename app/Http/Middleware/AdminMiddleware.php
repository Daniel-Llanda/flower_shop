<?php

namespace App\Http\Middleware;

use App\Models\Flower;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
    public function toggleVisibility($id)
    {
        $flower = Flower::findOrFail($id);
        $flower->is_visible = ! $flower->is_visible;
        $flower->save();

        return back()->with('success', 'Flower visibility updated.');
    }

}
