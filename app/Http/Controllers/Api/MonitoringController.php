<?php

namespace App\Http\Controllers\Api;

use App\Models\Monitoring;
use App\Response\Messages;
use Illuminate\Http\Request;
use App\Helpers\NotFoundHelpers;
use App\Functions\GlobalFunctions;
use App\Helpers\MonitoringHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonitoringResource;
use App\Http\Requests\Monitoring\StoreRequest;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitoring = Monitoring::useFilters()->dynamicPaginate();

        $response = NotFoundHelpers::notFoundData($monitoring);

        if ($response) {
            return $response;
        }

        new MonitoringResource($monitoring);

        return GlobalFunctions::responseFunction(
            Messages::MONITORING_DISPLAY,
            $monitoring
        );
    }

    public function show($id)
    {
        $monitoring = Monitoring::where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($monitoring);

        if ($response) {
            return $response;
        }

        new MonitoringResource($monitoring);

        return GlobalFunctions::responseFunction(
            Messages::MONITORING_DISPLAY,
            $monitoring
        );
    }

    public function store(StoreRequest $request)
    {
        return MonitoringHelpers::createMonitoring($request->all());
    }

    public function update(StoreRequest $request, $id)
    {
        $model = Monitoring::where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return MonitoringHelpers::updateMonitoring($model, $request->all());
    }

    public function destroy($id)
    {
        $model = Monitoring::withTrashed()
            ->where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return MonitoringHelpers::archivedMonitoring($model);
    }
}
