<?php


namespace Hogus\Tencent\Tim;


use Hogus\Tencent\Tim\Messages\Multi;

class GroupMessenger extends Messenger
{
    protected $online_only_flag = 0;

    public function onlineOnly($flag)
    {
        $this->online_only_flag = $flag;

        return $this;
    }

    public function send()
    {
        $prepends = [
            'GroupId' => $this->to,
            'Random' => rand(),
            // 'MsgPriority',
            // 'OfflinePushInfo',
            // 'ForbidCallbackControl',
            'OnlineOnlyFlag' => $this->online_only_flag,
            // 'SendMsgControl',
        ];

        if ($this->account) {
            $prepends['From_Account'] = $this->account;
        }

        $body = $this->message->transformForJsonRequest();

        $prepends['MsgBody'] = $this->message instanceof Multi ? $body : [$body];

        return $this->client->send($prepends);
    }
}
