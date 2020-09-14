<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all = Schedule::query();
        
        if ($request->client) {            
            $all = $all->where('klien','like','%'.$request->client.'%');
        }

        if ($request->agenda) {
            
            $all = $all->where('agenda','like','%'.$request->agenda.'%');
        }

        if ($request->date) {

            $all = $all->where('date',$request->date);
        }

        $all = $all->paginate('3');
        $data = schedule::all()->count();
        return view('schedule/index', compact('all','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'klien' => 'required',
            'date' => 'required',
            'time' => 'required',
            'agenda' => 'required',
            'participant' => 'required'
        ]);
        $data = $request->except('_token','submit');
        // dd($data);
        Schedule::create($data);
        return redirect('/schedule');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $id)
    {
        return view('schedule/show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $id)
    {
        return view('schedule/edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request,[
            'klien' => 'required',
            'date' => 'required',
            'time' => 'required',
            'agenda' => 'required',
            'participant' => 'required'
        ]);
        $data = $request->except('_token');
        $data = Schedule::findOrFail($id);
        $data->update($request->all());
        return redirect('/schedule');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Schedule::find($id);
        $delete->delete();
        return redirect('/schedule');
    }
    public function trash(Request $request)
    {

        $data = Schedule::onlyTrashed();
        if ($request->client) {    
            $data = $data->where('klien','like','%'.$request->client.'%');
        }

        if ($request->agenda) {
            $data = $data->where('agenda','like','%'.$request->agenda.'%');
        }

        if ($request->date) {
            $data = $data->where('date',$request->date);
        }

        $data = $data->get();
        
        return view('schedule/trash',compact('data'));
    }

    public function restore_all()
    {
        
        $restore = Schedule::onlyTrashed();
        $restore->restore();
        return redirect('/schedule/trash');
    }

    public function restore($id)
    {
        $restore = Schedule::onlyTrashed()->where('id',$id);
        $restore->restore();
        return redirect('/schedule/trash');
    }

    public function delete_all()
    {

        $delete = Schedule::onlyTrashed();
        $delete->forceDelete();
        return redirect('/schedule/trash');
    }

    public function delete($id)
    {
        $delete = Schedule::onlyTrashed()->where('id',$id);
        $delete->forceDelete();
        return redirect('/schedule/trash');
    }
}
