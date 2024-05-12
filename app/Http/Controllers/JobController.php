<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\UserJobsApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JobController extends Controller
{
    public function index(Request $request)
    {
        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function dashboard(){
        $jobs = Job::paginate(10); // Assuming you want to paginate the results
        return view('joblisting', ['dealer' => $jobs]);
    }

    public function getJobData($id){
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Job data fetched successfully',
            'data' => $job
        ]);
    }

    public function show(Request $request)
    {
        if ($request->has('id')) {
            // Fetch specific job by ID
            $job = Job::find($request->input('id'));
            if (!$job) {
                return $this->jsonResponse(null, 404, 'Job not found');
            }
            return $this->jsonResponse($job, 200, 'Data fetched successfully');
        }

        // Fetch all jobs
        $query = Job::query();
        // Apply filtering if filter parameters are provided
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhere('company_name', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhere('description', 'like', '%' . $request->input('keywords') . '%');
            });
        }
        // Apply default ordering by ID if no filter parameters are provided
        $jobs = $query->orderBy('id')->paginate(10);
        return $this->jsonResponse($jobs, 200, 'Job listings fetched successfully');
    }

    public function apply(Request $request)
    {
        $UserJobsApplication = UserJobsApplication::create([
            'user_id' => $request->input('user_id'),
            'job_id' => $request->input('job_id'),
            'application_date' => Carbon::today(),
        ]);
        return $this->jsonResponse(null, 200, 'Applied to job Successfully.');

    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'posted_date' => 'required|date',
        ]);

        // Save the new job listing to the database
        $job = Job::create([
            'job_title' => $validatedData['job_title'],
            'company_name' => $validatedData['company_name'],
            'location' => $validatedData['location'],
            'description' => $validatedData['description'],
            'requirements' => $validatedData['requirements'],
            'posted_date' => $validatedData['posted_date'],
        ]);

        return $this->jsonResponse(null, 200, 'Job posted successfully.');
    }
}
