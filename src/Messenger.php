<?php


namespace Hogus\Tencent\Tim;


use Hogus\Tencent\Tim\Clients\MessageClientInterface;
use Hogus\Tencent\Tim\Exceptions\MethodNotFoundException;
use Hogus\Tencent\Tim\Exceptions\RuntimeException;
use Hogus\Tencent\Tim\Messages\Message;
use Hogus\Tencent\Tim\Messages\Multi;
use Hogus\Tencent\Tim\Messages\Text;

class Messenger
{
    protected $client;

    /** @var Message */
    protected $message;

    /** @var string */
    protected $to;

    /** @var string */
    protected $account;

    /** @var int 消息离线保存时长 */
    protected $msg_lifetime = 7 * 86400;

    protected $sync_other_machine = 1;

    public function __construct(MessageClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * message
     *
     * @param string|Message $message
     *
     * @return Messenger
     */
    public function message($message): Messenger
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param $account
     *
     * @return Messenger
     */
    public function from($account): Messenger
    {
        $this->account = (string)$account;

        return $this;
    }

    /**
     *
     * @param $account
     *
     * @return Messenger
     */
    public function to($account): Messenger
    {
        $this->to = (string)$account;

        return $this;
    }

    /**
     * sync
     *
     * @param int $sync 1=>同步 2=>不同步
     *
     * @return Messenger
     */
    public function sync(int $sync): Messenger
    {
        $this->sync_other_machine = $sync;

        return $this;
    }

    /**
     * lifetime
     *
     * @param int $lifetime 消息离线保存时长（单位：秒），最长为7天（604800秒）
     *
     * @return Messenger
     */
    public function lifetime(int $lifetime): Messenger
    {
        $this->msg_lifetime = $lifetime;

        return $this;
    }

    /**
     * @return array|string
     *
     * @throws MethodNotFoundException
     * @throws RuntimeException
     */
    public function send()
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        $prepends = [
            'To_Account' => $this->to,
            'MsgRandom' => rand(),
            'SyncOtherMachine' => $this->sync_other_machine,
            'MsgLifeTime' => $this->msg_lifetime,
            'MsgTimeStamp' => time(),
            // 'ForbidCallbackControl' => "ForbidBeforeSendMsgCallback", //消息回调禁止开关，只对本条消息有效
            // 'SendMsgControl' => [], //消息发送控制选项
            // 'CloudCustomData' => [], //消息自定义数据
            // 'OfflinePushInfo' => [], //离线推送信息配置
        ];

        if ($this->account) {
            $prepends['From_Account'] = $this->account;
        }

        $body = $this->message->transformForJsonRequest();

        $prepends['MsgBody'] = $this->message instanceof Multi ? $body : [$body];

        // 单聊与批量发单聊
        $method = is_array($this->to) ? 'batch_send' : 'send';

        if (!method_exists($this->client, $method)) {
            throw new MethodNotFoundException(sprintf("Method `%s::%s()` is not defined.", get_class($this->client), $method));
        }

        return $this->client->$method($prepends);
    }

    /**
     * Return property.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}
