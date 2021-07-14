<?php


namespace Hogus\Tencent\Tim\Formats;


use Illuminate\Support\Str;

class GroupFormatter extends Formatter
{
    protected $required = [
        'type', 'name'
    ];

    protected $app_defined = [];

    protected $aliases = [
        'Type' => 'type',
        'Name' => 'name',
        'Owner_Account' => 'owner_id',
        'GroupId' => 'group_id',
        'Introduction' => 'introduction',
        'Notification' => 'notification',
        'FaceUrl' => 'face_url',
        'MaxMemberCount' => 'max_member_num',
        'ApplyJoinOption' => 'apply_join',
        'ShutUpAllMember' => 'shut_up_all',
        'MemberList' => 'member_list',
        'AppDefinedData' => 'app_define',
    ];

    public function group($group_id): GroupFormatter
    {
        $this->set('group_id', $group_id);

        return $this;
    }

    public function type($type): GroupFormatter
    {
        $this->set('type', Str::studly($type));

        return $this;
    }

    public function name($name): GroupFormatter
    {
        $this->set('name', $name);

        return $this;
    }

    public function owner($owner_id): GroupFormatter
    {
        $this->set('owner_id', (string)$owner_id);

        return $this;
    }

    public function define(array $defined): GroupFormatter
    {
        $this->set('app_define', $defined);

        return $this;
    }

    public function setDefine($key, $value): GroupFormatter
    {
        array_push($this->app_defined, [
            'Key' => $key,
            'Value' => $value
        ]);

        $this->define($this->app_defined);

        return $this;
    }

    public function shutUp(string $control): GroupFormatter
    {
        $this->set('shut_up_all', Str::studly($control));

        return $this;
    }

    /**
     * 关闭全员禁言
     *
     * @return $this
     */
    public function disableShutUp(): GroupFormatter
    {
        return $this->shutUp('off');
    }

    /**
     * 开启全员禁言
     *
     * @return $this
     */
    public function enableShutUp(): GroupFormatter
    {
        return $this->shutUp('on');
    }

    public function join(string $option): GroupFormatter
    {
        $this->set('apply_join', Str::studly($option));

        return $this;
    }

    public function freeAccessJoin(): GroupFormatter
    {
        return $this->join('FreeAccess');
    }

    public function NeedPermissionJoin(): GroupFormatter
    {
        return $this->join('NeedPermission');
    }

    public function disableApply(): GroupFormatter
    {
        return $this->join('DisableApply');
    }

    public function faceUrl(string $url): GroupFormatter
    {
        $this->set('face_url', $url);

        return $this;
    }

    public function intro(string $intro): GroupFormatter
    {
        $this->set('introduction', $intro);

        return $this;
    }

    public function count(int $num): GroupFormatter
    {
        $this->set('max_member_num', $num);

        return $this;
    }

    public function notification($notification): GroupFormatter
    {
        $this->set('notification', $notification);

        return $this;
    }

    /**
     * member
     *
     * @param array|GroupMemberFormatter $member
     *
     * @return $this
     */
    public function member($member): GroupFormatter
    {
        if ($member instanceof GroupMemberFormatter) {
            $member = $member->transformForJsonRequest();
        }

        $list = $this->get('member_list', []);

        array_push($list, (array)$member);

        $this->set('member_list', $list);

        return $this;
    }

    public function memberFormatter(): GroupMemberFormatter
    {
        return new GroupMemberFormatter($this->client);
    }

    /**
     * create
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create()
    {
        return $this->client->create($this->transformForJsonRequest());
    }

    /**
     * update
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update()
    {
        return $this->client->update($this->transformForJsonRequest());
    }

    public function import()
    {
        return $this->client->import($this->transformForJsonRequest());
    }
}
