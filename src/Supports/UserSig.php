<?php


namespace Hogus\Tencent\Tim\Supports;


use Hogus\Tencent\Tim\ServiceContainer;
use Illuminate\Support\Facades\Cache;
use Tencent\TLSSigAPIv2;

class UserSig
{
    protected $app;

    protected $cacheKeyPrefix = 'tim.usersig.';

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * getAppId
     *
     * @return array|mixed|null
     */
    public function getAppId()
    {
        return $this->app->config->get('app_id');
    }

    /**
     * getAppSecret
     *
     * @return array|mixed|null
     */
    public function getAppSecret()
    {
        return $this->app->config->get('app_secret');
    }

    /**
     * getUserid
     *
     * @return array|mixed|null
     */
    public function getUserid()
    {
        return $this->app->config->get('userid');
    }

    public function getSigExpire()
    {
        return $this->app->config->get('sig_expire', 86400 * 180);
    }


    public function genUserSig($userid, $expire = 86400*180): string
    {
        $tls = new TLSSigAPIv2($this->getAppId(), $this->getAppSecret());

        return $tls->genUserSig($userid, $expire);
    }

    /**
     *
     * @param bool $refresh
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function getUserSig(bool $refresh = false)
    {
        $cacheKey = $this->getCacheKey();

        if (!$refresh && Cache::has($cacheKey) && $usersig = Cache::get($cacheKey)) {
            return $usersig;
        }

        $usersig = $this->genUserSig($this->getUserid(), $expire = $this->getSigExpire());

        Cache::put($cacheKey, $usersig, $expire);

        return $usersig;
    }

    protected function getCacheKey(): string
    {
        return $this->cacheKeyPrefix.md5($this->getUserid());
    }
}
