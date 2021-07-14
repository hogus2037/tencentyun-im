<?php


namespace Hogus\Tencent\Tim\Clients\SNS;


use Hogus\Tencent\Tim\Clients\BaseClient;
use Hogus\Tencent\Tim\Pagination\BlackPaginator;
use Hogus\Tencent\Tim\Pagination\Paginator;

class BlackClient extends BaseClient
{
    const BLACK_CHECK_TYPE_SINGLE = 'BlackCheckResult_Type_Single';
    const BLACK_CHECK_TYPE_BOTH = 'BlackCheckResult_Type_Both';

    public function get(array $data)
    {
        return $this->httpPostJson('sns/black_list_get', $data);
    }

    public function add($from, $to)
    {
        return $this->httpPostJson('sns/black_list_add', [
            'From_Account' => (string) $from,
            'To_Account' => (array) $to,
        ]);
    }

    public function delete($from, $to)
    {
        return $this->httpPostJson('sns/black_list_delete', [
            'From_Account' => (string) $from,
            'To_Account' => (array) $to,
        ]);
    }

    public function check($from, $to, $type = self::BLACK_CHECK_TYPE_BOTH)
    {
        return $this->httpPostJson('sns/black_list_check', [
            'From_Account' => (string) $from,
            'To_Account' => (array) $to,
            'CheckType' => $type
        ]);
    }

    public function paginator(): Paginator
    {
        return new BlackPaginator($this);
    }
}
