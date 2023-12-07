<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\State;
use Carbon\Carbon;
use DataTables;
use Mail;

 
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
        
    
            $data = District::select('districts.*', 'states.state_name')
                ->join('states', 'districts.state_id', '=', 'states.id')
                ->orderBy('districts.created_at', 'DESC')
                ->get();

            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
  
        return view('district.index');
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::where('status', 'Active')->get();
        return view('district.create', compact('states'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       

        $request->validate([
         
            'district_name' => 'required|unique:districts,district_name', 
             'status' => 'required|string|max:255',
            'state_id' => 'required|integer',        
        ]);

      
        $model = District::create($request->all());

    
        return response()->json(['msg' => 'State Created Successfully'], 200);
    }

    // Method to display the update form
    public function edit($id)
    {
    
        $district = District::findOrFail($id);
        $states = State::where('status', 'Active')->get();

        return view('district.edit', compact('district','states'));
    }

    // Method to update state data
    public function update(Request $request, $id)
    {
        $state = District::findOrFail($id);
        $state->district_name = $request->input('district_name');
        $state->status = $request->input('status');
        // Update other fields as needed

        $state->save();

        return redirect()->route('district.edit', $id)->with('success', 'District updated successfully');
    }


     // Method to update state data
    public function updateStatus(Request $request, $id)
    {
        $state = District::findOrFail($id);
        $state->status = $state->status == 'Active' ? 'Inactive' : 'Active';;
        // Update other fields as needed

        $state->save();

        return redirect()->route('district.edit', $id)->with('success', 'District updated successfully');
    }


    public function get($stateId)
    {
        $districts = District::where('state_id', $stateId)->get();
        return response()->json($districts);
    }


  
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $State = District::findOrFail($id);
  
        $State->delete();
  
        return redirect()->route('district')->with('success', 'District deleted successfully');
    }
}