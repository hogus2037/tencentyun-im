<?php


namespace Hogus\Tencent\Tim\Tests;


use Hogus\Tencent\Tim\Clients\GroupClient;
use Hogus\Tencent\Tim\Supports\Filter;

class GroupTest extends TestCase
{
    public function testFind()
    {
        $client = $this->mockApiClient(GroupClient::class);

        $groupid = 'mock-groupid';

        $client->expects()->httpPostJson('group_open_http_svc/get_group_info', [
            'GroupIdList' => (array) $groupid,
            'ResponseFilter' => new Filter()
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->find('mock-groupid'));
    }
}
