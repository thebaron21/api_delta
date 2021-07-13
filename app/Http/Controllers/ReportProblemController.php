<?php

namespace App\Http\Controllers;

use App\Models\ReportProblem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportProblemController extends Controller
{
    public function create(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                "title"   => 'required|string',
                'content' => 'required|string|max:500'
            ]
        );
        if ($data->fails()) {
            return toJsonErrorModel($data->errors()->all());
        } else {
            $user = $request->user();
            $report = new ReportProblem();
            $report->user_id  = $user->id;
            $report->title    = $request->title;
            $report->content  = $request->content;
            $report->save();
            return toJsonModel($report);
        }
    }

    public function getReport(Request $request)
    {
        $user = User::with("reports")->get();
        return toJsonModel($user[0]["reports"]);
    }

    public function update(Request $request, $id)
    {
        $report = ReportProblem::find($id);
        if( strlen($report) <= 0 ){
            return toJsonErrorModel( [
                "status"    => false,
                "content"   => []
            ] );
        }else{            
            if ($request->has("title")) {
                $report->title = $request->title;
            }
            if ($request->has("content")) {
                $report->content = $request->content;
            }
            $report->save();
            return toJsonModel([
                "status"  => true,
                "content" => $report
            ]);
        }

    }
    public function destroy(Request $request, $id)
    {
        $report = ReportProblem::where(
            [
                "user_id" => $request->user()->id,
                "id"      => $id
            ]
        )->delete();
        return toJsonModel($report);
    }
}
