<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Interfaces\IPlanInterface;
use App\Models\Developer;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Plan;


class PlanRepository implements IPlanInterface
{
    public $developerRepo;
    public $taskRepo;
    public $week = 1;
    public $developer_weekly_capacity = 45;

    function __construct()
    {
        $this->developerRepo = new DeveloperRepository();
        $this->taskRepo = new TaskRepository();
    }


    /**
     * @return Collection
     */
    public function index(): Collection
    {

        $developers = $this->developerRepo->index();
        $tasks = $this->taskRepo->index();

        foreach ($tasks as $task) {
            $this->setTaskToDeveloper($task, $developers);
        }

        $plans = Plan::with('developer', 'task')->get();
        $plans = $plans->groupBy('week', function ($query) {
            $query->orderBy('start_time');
        });
        return $plans;
    }


    function checkDeveloperWorkSpace($developer, $week)
    {
        $developer_work_time = Plan::selectRaw('sum(end_time-start_time) as work_time')->where('developer_id', $developer->id)->where('week', $week)->first();
        if ($developer_work_time) {
            if (date('H', $developer_work_time->work_time) < $this->developer_weekly_capacity) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function findDeveloper($developers, $week)
    {
        foreach ($developers as $developer) {
            if ($this->checkDeveloperWorkSpace($developer, $week)) {
                return $developer;
            }
        }
    }

    function weekCompleted($week_number, $developer_count)
    {
        $plan = Plan::selectRaw('sum(end_time-start_time) as week_work')->where('week', $week_number);
        if ($plan) {
            if ($plan->week_work < 45 * $developer_count) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }


    }

    function setTaskToDeveloper($task, $developers)
    {
        $developer = $this->findDeveloper($developers, $this->week);
        if (($task->unit_work / $developer->difficulty) > $this->developer_weekly_capacity) {
            $plan = new Plan();
            $plan->task_id = $task->id;
            $plan->developer_id = $developer->id;
            $plan->week = $this->calculateWeek($plan->developer_id);
            $plan->start_time = $plan->week != 1 ? date('Y-m-d H:i:s', strtotime("+" . ($plan->week - 1) . " week")) : date('Y-m-d H:i:s');
            $plan->end_time = $this->calculateEndTime($task, $developer, $plan->start_time, $plan)['end_time'];
            $plan->total_end_time = $this->calculateEndTime($task, $developer, $plan->start_time, $plan)['total_end_time'];
            $task->unit_work -= date('H', (strtotime($plan->end_time) - strtotime($plan->start_time))) * $developer->difficulty;
            $task->save();
            $plan->save();
            while ($task->unit_work != 0) {
                $this->setTaskToDeveloper($task, $plan->developer_id);
            }
        } else {
            $plan = new Plan();
            $plan->task_id = $task->id;
            $plan->developer_id = $developer->id;
            $plan->week = $this->calculateWeek($plan->developer_id);
            $plan->start_time = $plan->week != 1 ? date('Y-m-d H:i:s', strtotime("+" . ($plan->week - 1) . " week")) : date('Y-m-d H:i:s');
            $plan->end_time = $this->calculateEndTime($task, $developer, $plan->start_time, $plan)['end_time'];
            $plan->total_end_time = $this->calculateEndTime($task, $developer, $plan->start_time, $plan)['total_end_time'];
            $task->unit_work -= date('H', (strtotime($plan->end_time) - strtotime($plan->start_time))) * $developer->difficulty;
            $plan->save();
        }
    }

    function calculateWeek($developer_id)
    {
        $week = 1;
        $plan = $this->getDeveloperWorkWeekly($developer_id, $week);

        while ($plan != null && $plan->total_work == $this->developer_weekly_capacity) {
            $week++;
            $plan = $this->getDeveloperWorkWeekly($developer_id, $week);
        }

        return $week;
    }

    function getDeveloperWorkWeekly($developer_id, $week)
    {
        $plan = Plan::selectRaw('sum(end_time-start_time) as total_work')->where('developer_id', $developer_id)->where('week', $week)->first();

        return $plan;
    }

    function calculateEndTime($task, $developer, $start_time, $plan)
    {
        $total_hour = $task->unit_work / $developer->difficulty;
        $total_end_time = date("Y-m-d H:i:s", strtotime("+" . $total_hour * 60 . " minutes", strtotime($start_time)));
        $plan->total_end_time = $total_end_time;
        if ($total_hour > 45) {
            return ["end_time" => date("Y-m-d H:i:s", strtotime("+45 hours", strtotime($start_time))), "total_end_time" => $plan->total_end_time];
        } else {
            return ["end_time" => date("Y-m-d H:i:s", strtotime("+" . $total_hour * 60 . " minutes", strtotime($start_time))), "total_end_time" => $plan->total_end_time];

        }
    }


}
