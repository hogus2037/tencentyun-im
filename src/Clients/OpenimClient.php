<?php


namespace Hogus\Tencent\Tim\Clients;


use Hogus\Tencent\Tim\Messages\Message;
use Hogus\Tencent\Tim\Messenger;

class OpenimClient extends BaseClient implements MessageClientInterface
{
    /**
     * message
     *
     * @param string|Message $message
     *
     * @return Messenger
     */
    public function message($message): Messenger
    {
        $class = new Messenger($this);

        return $class->message($message);
    }

    /**
     * 单聊
     *
     * @param array $message
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $message)
    {
        return $this->httpPostJson('openim/sendmsg', $message);
    }

    /**
     * 批量发单聊
     *
     * @param array $message
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batch_send(array $message)
    {
        return $this->httpPostJson('openim/batchsendmsg', $message);
    }

    public function get_roam_msg($from, $to, int $limit, int $start, int $end, string $cursor = null)
    {
        return $this->httpPostJson('openim/admin_getroammsg', [
            'From_Account' => $from,
            'To_Account' => $to,
            'MaxCnt' => $limit,
            'MinTime' => $start,
            'MaxTime' => $end,
            'LastMsgKey' => $cursor,
        ]);
    }
}
