<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskModel;

class TaskController extends Controller
{
    public function index()
    {
        // Fetch all tasks from the database
        $tasks = TaskModel::all();

        return view('home', compact('tasks'));
    }




    public function store(Request $request)
    {
        $requestData = $request->all();
        $taskName = $requestData['task_name'];
    
        // Create a new task instance and save it in the database
        $task = new TaskModel();
        $task->Task = $taskName;
        $task->save();
    
        // Get the ID of the newly created task
        $taskId = $task->id;
    
        // Return the task data in the response
        return response()->json(['status' => 'success', 'success' => 'Task added successfully!', 'tasks' => ['id' => $taskId, 'name' => $taskName]]);
    }
    
    

    
    
    public function delete($task_id)
    {
        // Find the task by ID
        $task = TaskModel::find($task_id);
   
        // Check if the task exists
        if ($task) {
            // Delete the task
            $task->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found.'
            ]);
        }
    }
    public function edit($task_id)
    {
        // Find the task by ID
        $task = TaskModel::find($task_id);
    
        // Check if the task exists
        if ($task) {
           // Return the task data in the response
            return response()->json([
            'status' => 'success',
            'data'=>$task,
               
            ]);
        } else {
            // Task not found, return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found.'
            ]);
        }
    }
    

    public function update(Request $request, $id)
    {
        // Retrieve the task from the database using the $id
        $task = TaskModel::find($id);
    
        if (!$task) {
            return response()->json(['status' => 'error', 'error' => 'Task not found']);
        }
    
        // Update the task with the new data from the request
        $task->Task = $request->input('task_name');
        // Add other fields if necessary
    
        // Save the updated task
        $task->save();
    
        // Return a response indicating the success of the update
        return response()->json(['status' => 'success', 'success' => 'Task updated successfully']);
    }
    
    
    
    
    }
