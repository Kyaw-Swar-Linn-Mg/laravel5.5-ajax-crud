<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ToDoList;
use Purifier;

class ListsController extends Controller
{

    //public function __construct()
    //{
        //$this->middleware('auth');
    //}

    public function index()
    {
        $lists = ToDoList::orderBy('id', 'desc')->get();
        return view('lists.index')->withLists($lists);
    }


    public function getTable()
    {
        $lists = ToDoList::orderBy('id', 'desc')->get();
        return view('lists.table')->withLists($lists);
    }


    public function store(Request $request)
    {   
        Validator::make($request->all(), [
            'title' => 'required|max:255',
            'item' => 'required'
        ])->validate();

        $list = new ToDoList();

        $list->title = $request->title;
        $list->item = Purifier::clean($request->item);

        $list->save();
        
        return response()->json([
            //'status' => 'success',
            'msg' => 'New item has been saved'
        ]);
    }


    public function show($id)
    {
        $list = ToDoList::find($id);

        return response()->json([
            'status' => 'success',
            'id' => $list->id,
            'title' => $list->title,
            'item' => $list->item,
        ]);
    }


    public function edit($id)
    {
        $list = ToDoList::find($id);

        return response()->json([
            //'status' => 'success',
            'id' => $list->id,
            'title' => $list->title,
            'item' => $list->item,
        ]);
    }


    public function update(Request $request, $id)
    {
        $list = ToDoList::find($id);

        Validator::make($request->all(), [
            'title' => 'required|max:255',
            'item' => 'required'
        ])->validate();

        $list->title = $request->title;
        $list->item = Purifier::clean($request->item);

        $list->save();
        
        return response()->json([
            'status' => 'success',
            'msg' => 'item has been updated'
        ]);
    }


    public function destroy($id)
    {
        $list = ToDoList::find($id);

        $list->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'item has been deleted'
        ]);
    }
}
