<?php


namespace Hogus\Tencent\Tim\Clients;


use GuzzleHttp\Middleware;
use Hogus\Tencent\Tim\ServiceContainer;
use Hogus\Tencent\Tim\Supports\HasHttpRequests;
use Hogus\Tencent\Tim\Supports\UserSig;
use Illuminate\Support\Arr;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    /** @var ServiceContainer  */
    protected $app;

    /** @var UserSig  */
    protected $sig;

    protected $base_uri = "https://console.tim.qq.com";
    protected $version = 'v4';
    protected $contenttype = 'json';

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        $this->sig = $app['user_sig'];
    }

    /**
     * getAppId
     *
     * @return array|mixed|null
     */
    public function getAppId()
    {
        return $this->app->config->get('app_id');
    }

    /**
     * getUserid
     *
     * @return array|mixed|null
     */
    public function getUserid()
    {
        return $this->app->config->get('userid');
    }

    /**
     * httpPostJson
     *
     * @param       $url
     * @param array $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPostJson($url, array $data = [])
    {
        return $this->request($this->formatRequestUrl($url), 'POST', [
            'query' => $this->getBaseQuery(),
            'json' => $data
        ]);
    }

    /**
     * formatRequestUrl
     *
     * @param $command
     *
     * @see https://cloud.tencent.com/document/product/269/1519#.E8.B0.83.E7.94.A8.E6.96.B9.E6.B3.95
     *
     * @return string
     */
    protected function formatRequestUrl($command)
    {
        return sprintf("%s/%s", $this->version, ltrim($command, '/'));
    }

    protected function getBaseQuery()
    {
        return [
            'sdkappid' => $this->getAppId(),
            'identifier' => $this->getUserid(),
            'contenttype' => $this->contenttype,
            'random' => rand(),
            'usersig' => $this->sig->getUserSig(),
        ];
    }

    /**
     * request
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method, array $options = [])
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }

        $response = $this->performRequest($url, $method, $options);

        return $this->unwrapResponse($response);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        // retry
        $this->pushMiddleware($this->retryMiddleware(), 'retry');
    }

    protected function retryMiddleware()
    {
        return Middleware::retry(function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null
        ) {
            // Limit the number of retries to 2
            if ($retries < 1 && $response && $body = $response->getBody()) {
                // Retry on server errors
                $response = json_decode($body, true);

                if (!empty($response['ErrorCode']) && in_array(abs($response['ErrorCode']), [70001], true)) {
                    $this->sig->getUserSig(true);

                    return true;
                }
            }

            return false;
        }, function () {
            return 500;
        });
    }

    protected function validate(array $params, $keys)
    {
        $keys = (array) $keys;

        foreach ($keys as $key) {
            if (is_null(Arr::get($params, $key))) {
                throw new \InvalidArgumentException("[$key] is required");
            }
        }

        return true;
    }
}
