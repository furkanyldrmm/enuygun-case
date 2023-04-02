<?php
namespace App\Managers\Provider;
use App\Services\Provider\IProviderService;
interface IProviderManager
{
    public function make($name): IProviderService;
}
