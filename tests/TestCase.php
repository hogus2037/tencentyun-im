<?php


namespace Hogus\Tencent\Tim\Tests;


use Hogus\Tencent\Tim\Application;
use Pimple\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    // use ArraySubsetAsserts;

    /**
     * mockApiClient
     *
     * @param string               $name
     * @param array|string          $methods
     * @param Container|null $app
     *
     * @return \Mockery\Mock
     */
    public function mockApiClient($name, $methods = [], Container $app = null)
    {
        $methods = implode(',', array_merge([
            'httpGet', 'httpPost', 'httpPostJson', 'httpUpload',
            'request', 'requestRaw', 'requestArray', 'registerMiddlewares',
        ], (array) $methods));

        $client = \Mockery::mock(
            $name."[{$methods}]",
            [
                $app ?? \Mockery::mock(Application::class)
            ]
        )->shouldAllowMockingProtectedMethods();

        $client->allows()->registerHttpMiddlewares()->andReturnNull();

        return $client;
    }
}
