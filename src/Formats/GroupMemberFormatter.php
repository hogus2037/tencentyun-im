<?php


namespace Hogus\Tencent\Tim\Formats;


class GroupMemberFormatter extends Formatter
{
    protected $app_member_define = [];

    protected $aliases = [
        'Member_Account' => 'member_id',
        'Role' => 'role',
        'AppMemberDefinedData' => 'app_member_define',
    ];

    protected $required = [
        'member_id'
    ];

    public function member($member_id): GroupMemberFormatter
    {
        $this->set('member_id', (string)$member_id);

        return $this;
    }

    public function role($role): GroupMemberFormatter
    {
        $this->set('role', $role);

        return $this;
    }

    public function define(array $defined): GroupMemberFormatter
    {
        $this->set('app_member_define', $defined);

        return $this;
    }

    public function setDefine($key, $value): GroupMemberFormatter
    {
        array_push($this->app_member_define, [
            'Key' => $key,
            'Value' => $value
        ]);

        $this->define($this->app_member_define);

        return $this;
    }
}
