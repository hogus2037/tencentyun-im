<?php


namespace Hogus\Tencent\Tim\Clients;


use Hogus\Tencent\Tim\Formats\Formatter;
use Hogus\Tencent\Tim\Formats\FormatterInterface;
use Hogus\Tencent\Tim\Formats\GroupFormatter;
use Hogus\Tencent\Tim\GroupMessenger;
use Hogus\Tencent\Tim\Messages\Message;
use Hogus\Tencent\Tim\Messenger;
use Hogus\Tencent\Tim\Pagination\GroupPaginator;
use Hogus\Tencent\Tim\Pagination\Paginator;
use Hogus\Tencent\Tim\Supports\Filter;

/**
 * Class GroupClient
 *
 * @package Hogus\Tencent\Tim\Clients
 */
class GroupClient extends BaseClient implements MessageClientInterface, FormatterInterface
{
    /**
     * get
     *
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(array $data = [])
    {
        return $this->httpPostJson('group_open_http_svc/get_appid_group_list', $data);
    }

    /**
     * paginator
     *
     * @return Paginator
     */
    public function paginator(): Paginator
    {
        return new GroupPaginator($this);
    }

    /**
     * 获取群详细资料
     *
     * @param mixed        $group_id 群ID
     * @param Filter|array $filter 过滤单元
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($group_id, $filter = null)
    {
        return $this->httpPostJson('group_open_http_svc/get_group_info', [
            'GroupIdList' => (array)$group_id,
            'ResponseFilter' => $filter
        ]);
    }

    /**
     * 陌生人社交群
     *
     * @param array|Formatter  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_public_group($data)
    {
        return $this->create_group('Public', $data);
    }

    /**
     * 好友工作群
     *
     * @param array|Formatter  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_work_group($data)
    {
        return $this->create_group('Private', $data);
    }

    /**
     * 会议群
     *
     * @param array|Formatter  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_meeting_group($data)
    {
        return $this->create_group('ChatRoom', $data);
    }

    /**
     * 直播群
     *
     * @param array|Formatter  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_live_group($data)
    {
        return $this->create_group('AVChatRoom', $data);
    }

    /**
     * 创建群组
     *
     * @param string $type
     * @param array|Formatter  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_group(string $type, $data)
    {
        $format = $data instanceof Formatter ? $data : $this->formatter((array)$data);

        return $format->type($type)->create();
    }

    /**
     * 修改群基础资料
     *
     * @see https://cloud.tencent.com/document/product/269/1620
     *
     * @param mixed $group_id
     * @param array|Formatter $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update_group($group_id, $data)
    {
        $format = $data instanceof Formatter ? $data : $this->formatter((array)$data);

        return $format->group($group_id)->update();
    }

    /**
     * formatter
     *
     * @param array $attributes
     *
     * @return GroupFormatter
     */
    public function formatter(array $attributes = []): Formatter
    {
        return new GroupFormatter($this, $attributes);
    }

    /**
     * 创建群组
     *
     * @see https://cloud.tencent.com/document/product/269/1615
     *
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        return $this->httpPostJson('group_open_http_svc/create_group', $data);
    }

    /**
     * 修改群基础资料
     *
     * @see https://cloud.tencent.com/document/product/269/1620
     *
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $data)
    {
        return $this->httpPostJson('group_open_http_svc/modify_group_base_info', $data);
    }

    /**
     * 解散群组
     *
     * @param $group_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($group_id)
    {
        return $this->httpPostJson('group_open_http_svc/destroy_group', [
            'GroupId' => (string)$group_id
        ]);
    }

    /**
     * 转入群主
     *
     * @param $group_id
     * @param $owner_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function change($group_id, $owner_id)
    {
        return $this->httpPostJson('group_open_http_svc/change_group_owner', [
            'GroupId' => (string)$group_id,
            'NewOwner_Account' => (string)$owner_id
        ]);
    }

    /**
     * 导入群资料
     *
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import(array $data)
    {
        return $this->httpPostJson('group_open_http_svc/import_group', $data);
    }

    /**
     * 导入群消息
     *
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import_msg(array $data)
    {
        return $this->httpPostJson('group_open_http_svc/import_group_msg', $data);
    }

    /**
     * 导入群成员
     *
     * @param          $group_id
     * @param          $member_id
     * @param string   $role
     * @param int|null $join_time
     * @param int      $unread_msg_num
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import_member($group_id, $member_id, string $role, int $join_time = null, int $unread_msg_num = 0)
    {
        $member_list[] = [
            'Member_Account' => (string) $member_id,
            'Role' => $role,
            'JoinTime' => $join_time ?? time(),
            'UnreadMsgNum' => $unread_msg_num
        ];

        return $this->app['group_member']->import($group_id, $member_list);
    }

    /**
     * message
     *
     * @param string|Message $message
     *
     * @return GroupMessenger
     */
    public function message($message): Messenger
    {
        $class = new GroupMessenger($this);

        return $class->message($message);
    }

    /**
     * send
     *
     * @param array $message
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $message)
    {
        return $this->httpPostJson('group_open_http_svc/send_group_msg', $message);
    }

    /**
     * 发送群公告
     *
     * @param        $group_id
     * @param string $content
     * @param array  $member_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function notification($group_id, string $content, array $member_id = [])
    {
        return $this->httpPostJson('group_open_http_svc/send_group_system_notification', [
            'GroupId' => (string)$group_id,
            'Content' => $content,
            'ToMembers_Account' => $member_id
        ]);
    }

    /**
     * 批量禁言和取消禁言
     *
     * @param mixed       $group_id 需要查询的群组ID
     * @param array|mixed $member_id 需要禁言的用户帐号，最多支持500个帐号
     * @param int         $shut_up_time 需禁言时间，单位为秒，为0时表示取消禁言
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function forbid($group_id, $member_id, int $shut_up_time)
    {
        return $this->httpPostJson('group_open_http_svc/forbid_send_msg', [
            'GroupId' => (string)$group_id,
            'ShutUpTime' => $shut_up_time,
            'Members_Account' => (array)$member_id
        ]);
    }

    /**
     * 获取直播群在线人数
     *
     * @param mixed $group_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get_online_member_num($group_id)
    {
        return $this->httpPostJson('group_open_http_svc/get_online_member_num', [
            'GroupId' => (string)$group_id,
        ]);
    }

    /**
     * 获取被禁言群成员列表
     *
     * @param $group_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function shutted_list($group_id)
    {
        return $this->httpPostJson('group_open_http_svc/get_group_shutted_uin', [
            'GroupId' => (string)$group_id,
        ]);
    }

    /**
     * 撤回群消息
     *
     * @param $group_id
     * @param $seq
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function recall_msg($group_id, $seq)
    {
        return $this->httpPostJson('group_open_http_svc/group_msg_recall', [
            'GroupId' => (string)$group_id,
            'MsgSeqList' => array_map(function ($seq) {
                return ['MsgSeq' => $seq];
            }, (array)$seq)
        ]);
    }

    /**
     * 拉取群历史消息
     *
     * @param     $group_id
     * @param int $seq
     * @param int $num
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get_msg_list($group_id, int $seq = 0, int $num = 20)
    {
        $data = [
            'GroupId' => (string)$group_id,
            'ReqMsgNumber' => min($num, 20)
        ];

        if ($seq > 0) {
            $data['ReqMsgSeq'] = $seq;
        }

        return $this->httpPostJson('group_open_http_svc/group_msg_get_simple', $data);
    }

    /**
     * 删除指定用户发送的消息
     *
     * @param $group_id
     * @param $member_id
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete_msg_by_sender($group_id, $member_id)
    {
        return $this->httpPostJson('group_open_http_svc/delete_group_msg_by_sender', [
            'GroupId' => (string)$group_id,
            'Sender_Account' => (string)$member_id,
        ]);
    }

    /**
     * 设置成员未读消息计数
     *
     * @param     $group_id
     * @param     $member_id
     * @param int $num
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function set_unread_msg_num($group_id, $member_id, int $num)
    {
        return $this->httpPostJson('group_open_http_svc/set_unread_msg_num', [
            'GroupId' => (string)$group_id,
            'Member_Account' => (string)$member_id,
            'UnreadMsgNum' => $num,
        ]);
    }
}
