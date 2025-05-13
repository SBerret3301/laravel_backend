<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VerifyCsrfToken
{
    /**
     * قائمة الاستثناءات من تحقق CSRF.
     *
     * @var array
     */
    protected $except = [
        // أضف هنا المسارات التي لا تحتاج إلى تحقق CSRF
    ];

    /**
     * التعامل مع الطلب والتحقق من CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق إذا كانت المسار غير مستثنى من تحقق CSRF
        if (!$this->isReading($request) && !$this->isTesting() && !$this->inExceptArray($request)) {
            // التحقق من صحة رمز CSRF في الطلب
            $this->verifyCsrfToken($request);
        }

        return $next($request);
    }

    /**
     * التحقق من صحة رمز CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    protected function verifyCsrfToken(Request $request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        // إذا لم يكن هناك رمز CSجب في الطلب، سيتم رمي الاستثناء
        if ($token !== $request->session()->token()) {
            throw new TokenMismatchException('The CSRF token is invalid.');
        }
    }

    /**
     * تحديد ما إذا كان الطلب يقرأ فقط (مثل GET).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isReading(Request $request)
    {
        return $request->isMethod('get') || $request->isMethod('head');
    }

    /**
     * تحديد ما إذا كان الطلب يقع ضمن استثناءات CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray(Request $request)
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * تحديد ما إذا كان التطبيق في وضع اختبار.
     *
     * @return bool
     */
    protected function isTesting()
    {
        return app()->runningInConsole() && env('APP_ENV') === 'testing';
    }
}
