<?php

namespace App\Http\Controllers;

use App\Http\Services\Interfaces\IPlanInterface;

class PlanController extends Controller
{
    /**
     * @var IPlanInterface
     */
    private IPlanInterface $plan;

    /**
     * Create a new interface instance.
     * PlanController constructor.
     *
     * @param IPlanInterface $plan
     */
    public function __construct(IPlanInterface $plan)
    {
        $this->plan = $plan;
    }

    public function index(){


        $generated_plan= $this->plan->index();

        return view('index')->with('plans',$generated_plan);
    }
}
