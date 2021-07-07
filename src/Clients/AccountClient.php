<?php


namespace Hogus\Tencent\Tim\Clients;


use Illuminate\Support\Facades\Cache;

class AccountClient extends BaseClient
{
    /**
     * 导入单个账号
     *
     * @param $userid
     * @param $nickname
     * @param $avatar
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import($userid, $nickname, $avatar)
    {
        return $this->httpPostJson('im_open_login_svc/account_import', [
            'Identifier' => (string)$userid,
            'Nick' => $nickname,
            'FaceUrl' => $avatar,
        ]);
    }

    /**
     * 查询
     *
     * @param $member_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check($member_id)
    {
        $item = [];

        $member_id = (array) $member_id;

        foreach ($member_id as $id) {
            $item[] = ['UserID' => (string) $id];
        }

        return $this->httpPostJson('im_open_login_svc/account_check', [
            'CheckItem' => $item
        ]);
    }

    /**
     * 查询帐号在线状态
     *
     * @param     $member_id
     * @param int $is_need_detail
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function querystate($member_id, int $is_need_detail = 0)
    {
        return $this->httpPostJson('openim/querystate', [
            'To_Account' => (array) $member_id,
            'IsNeedDetail' => $is_need_detail,
        ]);
    }

    /**
     * 失效帐号登录状态
     *
     * 将 App 用户帐号的登录状态（例如 UserSig）失效
     *
     * @param $member_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kick($member_id)
    {
        return $this->httpPostJson('im_open_login_svc/kick', [
            'Identifier' => (string)$member_id,
        ]);
    }

    /**
     * login
     *
     * @param     $userid
     * @param int $expire
     *
     * @return string
     * @throws \Exception
     */
    public function login($userid, int $expire = 86400*180): string
    {
        $cache_key = 'tim.usersig.'.md5($userid);

        if (Cache::has($cache_key) && $sig = Cache::get($cache_key)) {
            return $sig;
        }

        Cache::put($cache_key, $sig = $this->sig->genUserSig($userid, $expire), $expire);

        return $sig;
    }
}
