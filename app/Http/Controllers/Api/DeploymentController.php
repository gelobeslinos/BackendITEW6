<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeploymentController extends Controller
{
    public function index()
    {
        try {
            $deployments = Deployment::with(['student', 'professor'])->orderBy('id', 'desc')->get();
            return response()->json(['data' => $deployments]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'professor_id' => 'required|integer|exists:employees,id',
            'subject' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:active,completed',
        ]);

        $deployment = Deployment::create($validated);

        return response()->json($deployment, Response::HTTP_CREATED);
    }

    public function show(Deployment $deployment)
    {
        $deployment->load(['student', 'professor']);
        return response()->json($deployment);
    }

    public function update(Request $request, Deployment $deployment)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'professor_id' => 'required|integer|exists:employees,id',
            'subject' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:active,completed',
        ]);

        $deployment->update($validated);

        return response()->json($deployment);
    }

    public function destroy(Deployment $deployment)
    {
        $deployment->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
