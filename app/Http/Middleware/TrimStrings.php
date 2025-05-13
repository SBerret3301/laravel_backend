<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrimStrings
{
    /**
     * المسار الذي سيتم تطبيق الميدل وير عليه.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // تصفية الحقول المدخلة من المسافات الفارغة
        $request->merge(array_map('trim', $request->all()));

        return $next($request);
    }
}
