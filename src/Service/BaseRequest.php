<?php

namespace PlanetaDelEste\Ucfe\Service;

use Exception;
use Illuminate\Support\Arr;
use PlanetaDelEste\Ucfe\Client;

abstract class BaseRequest extends Client
{
    /**
     * @var array
     */
    protected array $arData = [];

    /**
     * @var array
     */
    protected array $arKeys = [];

    /**
     * @param string $name
     * @param mixed  $arguments
     *
     * @return mixed|null
     */
    public function __call(string $name, $arguments = [])
    {
        if (!in_array($name, $this->arKeys)) {
            return null;
        }

        $sValue = is_array($arguments) && !empty($arguments) ? $arguments[0] : $arguments;

        if ((!empty($sValue) || is_bool($sValue) || is_numeric($sValue))) {
            Arr::set($this->arData, $name, $sValue);
        }

        return Arr::get($this->arData, $name);
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function send()
    {
        return $this->exec($this->getSendData());
    }

    /**
     * @return array
     */
    abstract protected function getSendData(): array;

    /**
     * @return string
     */
    protected function getResponseClass(): string
    {
        return BaseResponse::class;
    }
}
