<?php


namespace Hogus\Tencent\Tim\Clients;


use Hogus\Tencent\Tim\Messenger;

interface MessageClientInterface
{
    public function message($message): Messenger;

    public function send(array $message);
}
