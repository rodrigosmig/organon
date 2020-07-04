<?php

namespace App\Http\Middleware;

use Closure;
use App\Client;
use RealRashid\SweetAlert\Facades\Alert;

class ClientOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->hasParameter('client_id')) {
            $id = $request->route()->parameter('client_id');
            $client = Client::where('id', $id)
                        ->where('owner_id', auth()->user()->id)
                        ->first();

            if (! $client) {
                Alert::error(__('client.not_found'), __('client.message.not_found'));
                return redirect()->route('clients.index');
            }
        }
        return $next($request);
    }
}
