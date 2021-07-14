<?php


namespace Hogus\Tencent\Tim\Clients;


use Hogus\Tencent\Tim\Pagination\GroupMemberPaginator;
use Hogus\Tencent\Tim\Pagination\Paginator;

class GroupMemberClient extends BaseClient
{
    public function get(array $data)
    {
        return $this->httpPostJson('group_open_http_svc/get_group_member_info', $data);
    }

    public function paginator(): Paginator
    {
        return new GroupMemberPaginator($this);
    }

    /**
     * 添加群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1621
     *
     * @param mixed        $group_id 群ID
     * @param array|string $member_ids 用户ID
     * @param int          $silence 0：非静默加人；1：静默加人
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add($group_id, $member_ids, int $silence = 0)
    {
        $member_ids = (array) $member_ids;

        $member_list = [];
        foreach ($member_ids as $member_id) {
            $member_list[] = ['Member_Account' => (string)$member_id];
        }

        return $this->httpPostJson('group_open_http_svc/add_group_member', [
            'GroupId' => $group_id,
            'Silence' => $silence,
            'MemberList' => $member_list
        ]);
    }

    /**
     * 删除群成员
     *
     * @param mixed            $group_id 群id
     * @param array|string|int $member_id 群员id
     * @param int              $silence 是否静默删人。0表示非静默删人，1表示静默删人。静默即删除成员时不通知群里所有成员，只通知被删除群成员。不填写该字段时默认为0
     * @param string|null      $reason 踢出用户原因
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($group_id, $member_id, int $silence = 0, string $reason = null)
    {
        return $this->httpPostJson('group_open_http_svc/delete_group_member', [
            'GroupId' => $group_id,
            'MemberToDel_Account' => (array)$member_id,
            'Silence' => $silence,
            'Reason' => $reason
        ]);
    }

    /**
     * 导入群成员
     *
     * @param       $group_id
     * @param array $member_list
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import($group_id, array $member_list)
    {
        return $this->httpPostJson('group_open_http_svc/import_group_member', [
            'GroupId' => $group_id,
            'MemberList' => $member_list,
        ]);
    }

    /**
     * 修改群会员资料
     *
     * @param       $group_id
     * @param       $member_id
     * @param array $attributes
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($group_id, $member_id, array $attributes)
    {
        // $params = [
        //     'Role' => $attributes['role'],
        //     'MsgFlag' => $attributes['msg_flag'],
        //     'NameCard' => $attributes['name_card'],
        //     'ShutUpTime' => $attributes['shut_up_time'],
        //     'AppMemberDefinedData' => $attributes['AppMemberDefinedData'],
        // ];

        return $this->httpPostJson('group_open_http_svc/add_group_member', array_merge([
            'GroupId' => $group_id,
            'Member_Account' => (string)$member_id,
        ], $attributes));
    }

    /**
     * 修改会员角色
     *
     * @param        $group_id
     * @param        $member_id
     * @param string $role
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update_role($group_id, $member_id, string $role)
    {
        return $this->update($group_id, $member_id, [
            'Role' => $role
        ]);
    }

    /**
     * 设置成员消息屏蔽位
     *
     * @param     $group_id
     * @param     $member_id
     * @param int $flag
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update_flag($group_id, $member_id, int $flag)
    {
        return $this->update($group_id, $member_id, [
            'MsgFlag' => $flag
        ]);
    }

    /**
     * 设置成员的群名片
     *
     * @param        $group_id
     * @param        $member_id
     * @param string $name_card
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update_name_card($group_id, $member_id, string $name_card)
    {
        return $this->update($group_id, $member_id, [
            'NameCard' => $name_card
        ]);
    }

    /**
     * 设置群成员禁言时间
     *
     * @param     $group_id
     * @param     $member_id
     * @param int $shut_up_time
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update_shut_up($group_id, $member_id, int $shut_up_time = 0)
    {
        return $this->update($group_id, $member_id, [
            'ShutUpTime' => $shut_up_time
        ]);
    }

    /**
     * 查询用户在群组中的身份
     *
     * @param $group_id
     * @param $member_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function role($group_id, $member_id)
    {
        return $this->httpPostJson('group_open_http_svc/get_role_in_group', [
            'GroupId' => (string)$group_id,
            'User_Account' => (array)$member_id
        ]);
    }

    public function joined($group_id, $member_id)
    {
        return $this->httpPostJson('group_open_http_svc/get_joined_group_list', '');
    }
}
