<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * التعامل مع الطلب.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        return $next($request);
    }

    /**
     * توثيق المستخدم.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards)
    {
        if (empty($guards)) {
            $guards = [null]; // يستخدم Guard الافتراضي إذا لم يتم تحديده
        }

        foreach ($guards as $guard) {
            // التحقق من أن المستخدم قد تم توثيقه في الحارس المحدد
            if (Auth::guard($guard)->check()) {
                return;
            }
        }

        // إذا لم يتم العثور على مستخدم موثوق فيه، يتم رمي استثناء
        throw new AuthenticationException('Unauthenticated.');
    }
}
