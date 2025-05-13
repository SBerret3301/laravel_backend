<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class EncryptCookies
{
    /**
     * قائمة الكوكيز التي يجب عدم تشفيرها.
     *
     * @var array
     */
    protected $except = [
        // أضف أسماء الكوكيز التي لا تريد تشفيرها هنا
    ];

    /**
     * التعامل مع الطلب.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // تشفير الكوكيز التي لم يتم استثناؤها
        $this->encryptCookies($request);

        return $next($request);
    }

    /**
     * تشفير الكوكيز في الاستجابة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function encryptCookies(Request $request)
    {
        // الحصول على جميع الكوكيز من الطلب
        $cookies = $request->cookies->all();

        foreach ($cookies as $name => $value) {
            // التحقق إذا كان الكوكيز في الاستثناءات
            if (!in_array($name, $this->except)) {
                // تشفير الكوكيز
                $request->cookies->set($name, encrypt($value));
            }
        }
    }
}
