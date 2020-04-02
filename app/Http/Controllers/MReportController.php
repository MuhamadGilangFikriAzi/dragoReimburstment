<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MReport;
use App\Models\Schedule;

class MReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MReport::all();
		return view('meeting_report.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Schedule::all();
        return view('meeting_report.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
			'schedule_id.required' => '*Agenda must be filled',
			'time_finished.required' => '*Time Finished must be filled',
			'client_person.required' => '*Client Person must be filled',
			'document.required' => '*Document must be filled',
		];

		$this->validate($request,[
			'schedule_id' => 'required',
			'time_finished' => 'required',
			'client_person' => 'required',
			'document'		=> 'required|file|max:2000',
		]);


		$this->validate($request,$message);

		$mreport = $request->except('_token');
		$data = MReport::query();

		if(request()->document){
			$uploadedFile = $request->file('document');

			$name = $uploadedFile->getClientOriginalName();
		
			$path = public_path('doc_report/');
			$file = MReport::create([
				'schedule_id' => $request->schedule_id,
				'time_finished' => $request->time_finished,
				'client_person' => $request->client_person,
				'document' 		=> $name
			]);
			$data = $uploadedFile->move($path,$name);
			

		}
		return redirect('mreport');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MReport $id)
    {
        $id->with('schedule')->get();
		return view('meeting_report.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MReport $id)
    {
        $id->with('schedule')->get();
		$data = Schedule::all();
		return view('meeting_report.edit',compact('id','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MReport $id)
    {
        $this->validate($request,[
			'time_finished' => 'required',
			'client_person' => 'required',
		]);

		$data = $request->except('_token');
		$data = MReport::findOrFail($id)->first()->fill($request->all());
		$data->update();

		if($request->document != null)
		{	
			$updatedFile = $request->file('document');
			$name = $updatedFile->getClientOriginalName();
			$path = public_path('doc_report/');
		
			$data['document'] = $name; 
			$data->save();

			$data = $updatedFile->move($path,$name);
		}
		
		return redirect('mreport');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = MReport::find($id);
		$path 	= public_path('/doc_report/');
	    $destroy->delete();
		return redirect('mreport')->with('message', 'File was deleted');
    }
}
