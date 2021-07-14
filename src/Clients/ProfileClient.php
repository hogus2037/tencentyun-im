<?php


namespace Hogus\Tencent\Tim\Clients;


class ProfileClient extends BaseClient
{
    public function get($userid, $tag)
    {
        return $this->httpPostJson('profile/portrait_get', [
            'To_Account' => (array)$userid,
            'TagList' => (array)$tag
        ]);
    }

    public function update($userid, array $profiles)
    {
        return $this->httpPostJson('profile/portrait_set', [
            'From_Account' => (string)$userid,
            'ProfileItem' => $this->formatData($profiles),
        ]);
    }

    protected function formatData($data)
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            if (is_numeric($key) && is_array($value)) {
                $formatted[$key] = $value;

                continue;
            }

            $formatted[] = [
                'Tag' => $key,
                'Value' => $value,
            ];
        }

        return $formatted;
    }
}
