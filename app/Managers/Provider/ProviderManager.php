<?php
namespace App\Managers\Provider;
use App\Services\Provider\FirstProviderService;
use App\Services\Provider\SecondProviderService;
use App\Services\Provider\IProviderService;
use Illuminate\Support\Arr;
class ProviderManager implements IProviderManager
{
    private $shops = [];
    private $app;
    public function __construct($app)
    {
        $this->app = $app;
    }
    public function make($name): IProviderService
    {
        $service = Arr::get($this->shops, $name);
        // No need to create the service every time
        if ($service) {
            return $service;
        }
        $createMethod = 'create' . ucfirst($name) . 'ProviderService';
        if (!method_exists($this, $createMethod)) {
            throw new \Exception("Provider $name is not supported");
        }
        $service = $this->{$createMethod}();
        $this->shops[$name] = $service;
        return $service;
    }
    private function createFirstProviderService(): FirstProviderService
    {
        dump("Creating FirstProviderService...");
        $service = new FirstProviderService();
        return $service;
    }
    private function createSecondProviderService(): SecondProviderService
    {
        dump("Creating SecondProviderService...");
        $service = new SecondProviderService();
        return $service;
    }
}
