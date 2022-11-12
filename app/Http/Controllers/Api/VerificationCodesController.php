<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerficationCodeRequest;

/**
 * 验证短信控制其
 */
class VerificationCodesController extends Controller
{
    /**
     * 发送
     */
    public function store(VerficationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;

        //随机生成4位验证码,左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        try{
            //调用发送
            $result = $easySms->send($phone,[
                'template' => config('easysms.gateways.aliyun.templates.register'),
                'data' => [
                    'code' => $code
                ]
                //'content' => "【laravel-onlie】您的验证码是{$code}.如非本人操作，请忽略本短信。"
            ]);
        }catch(\Overtrue\EasySms\Exceptions\NoGetwayAvailableException $exception)
        {
            $message = $exception->getException('aliyun')->getMessage();
            return $this->response->errorInternal($message ?: '短信发送异常');
        }

        $key = 'verificationCode_' . str_random(15);
        $expiredAt = now()->addMinutes(5);
        //缓存验证码 5分钟过期设置
        \Cache::put($key,['phone' => $phone, 'code' => $code], $expiredAt);

        //注意：这里的Key没有直接使用【手机号】作为key，如果使用手机号作为key那么如果这个手机号同时有两个请求，那么一定会有一个不通过
        //为了防止上面的情况出现，可以使用【手机号】+【几位随机字符串】

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt ->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
