<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class PreventRequestsDuringMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // إذا كان التطبيق في وضع الصيانة
        if (App::isDownForMaintenance()) {
            // يمكنك تخصيص الرد أثناء الصيانة، مثل إرسال صفحة صيانة أو رد آخر
            return response()->view('maintenance');  // تأكد من أن لديك عرض بإسم "maintenance"
        }

        return $next($request);
    }
}
