<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\AssignTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function allTasks(Request $request)
    {
        $currentDate = Carbon::now()->toDateString(); // Get current date (format: YYYY-MM-DD)

        $previousTasks = Task::whereDate('due_date', '<', $currentDate)->get();
        $todayTasks = Task::whereDate('due_date', $currentDate)->get();
        $nextTasks = Task::whereDate('due_date', '>', $currentDate)->get();

        return response()->json([
            'previous' => $previousTasks,
            'today' => $todayTasks,
            'next' => $nextTasks
        ]);
    }

     public function store(Request $request)
    {
        // Validate incoming request data (example: task name is required)
        $request->validate([
            'title' => 'required|string',
            'description' => 'required',
            'due_date' => 'required|date',
            'priority' => 'required',
        ]);
        // Create a new task
        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
        ]);

        // Return the created task as JSON response
        return response()->json($task, 201);
    }
    public function editTask($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }
    public function updateTask(Request $request, $id)
    {
        // dd($request->all());
         $request->validate([
            'title' => 'required|string',
            'description' => 'required',
            'due_date' => 'required|date',
            'priority' => 'required',
        ]);
        $task = Task::find($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
        $task->update();
        return response()->json($task);
    }
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json('Task deleted successfully');
    }
    public function allAssignTasks(Request $request)
    {
         $authUserId = auth()->user()->id;

        // Fetch all assignments for the authenticated user
        $assignedTasks = AssignTask::with('task')  // Ensure the relationship is defined in AssignTask model
                            ->where('user_id', $authUserId)
                            ->get();

        $currentDate = Carbon::now()->toDateString(); // Get current date (format: YYYY-MM-DD)
// dd($currentDate);
        $previousTasks = [];
        $todayTasks = [];
        $nextTasks = [];

        foreach ($assignedTasks as $assignedTask) {
            // Create an array that includes task details and assignTask information
            $taskDetails = [
                'task' => $assignedTask->task,  // Actual task details
                'status' => $assignedTask->status,  // Status from AssignTask
                'comment' => $assignedTask->comment,  // Assuming comment field exists
                'id' => $assignedTask->id,  // Assuming comment field exists
            ];
            $dueDate = substr($assignedTask->task->due_date, 0, 10);
            // Compare task due date with current date and categorize accordingly
            if ($dueDate < $currentDate) {
                $previousTasks[] = $taskDetails;
            } elseif ($dueDate == $currentDate) {
                $todayTasks[] = $taskDetails;
            } elseif ($dueDate > $currentDate) {
                $nextTasks[] = $taskDetails;
            }
        }

        return response()->json([
            'previous' => $previousTasks,
            'today' => $todayTasks,
            'next' => $nextTasks
        ]);
    }
    public function assignTaskStore(Request $request)
    {
          $request->validate([
            'user_id' => 'required',
            'task_id' => 'required'
        ]);
        // Create a new task
        $existingAssignTask = AssignTask::where('user_id', $request->input('user_id'))
        ->where('task_id', $request->input('task_id'))->first();
        if($existingAssignTask){
            return response()->json('Task already assigned to user', 400);
        }else{
            $task = AssignTask::create([
                'user_id' => $request->input('user_id'),
                'task_id' => $request->input('task_id'),
            ]);
            // Return the created task as JSON response
            return response()->json($task, 201);
        }
    }
    public function editAssignTask(Request $request, $id){

         $assignTask = AssignTask::with('task')->find($id);
        // dd($assignTask);
        return response()->json($assignTask);
    }
    public function updateAssignTask(Request $request, $id){
        $assignTask = AssignTask::find($id);
        $assignTask->status = $request->input('status');
        $assignTask->comment = $request->input('comment');
        $assignTask->update();
         return response()->json($assignTask, 201);
    }
    public function tasks(){
        $tasks = Task::all();
        return response()->json($tasks);
    }
    public function users(){
        $users = User::all();
        return response()->json($users);
    }


}