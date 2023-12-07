<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\State;
use Carbon\Carbon;
use DataTables;
use Mail;

 
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
        
            $data = State::orderBy('created_at', 'DESC')->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
  
        return view('state.index');
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('state.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
         
            'state_name' => 'required|unique:states,state_name', 
            'status' => 'required|string|max:255',
        ]);

      
        $model = State::create($request->all());

    
        return response()->json(['msg' => 'State Created Successfully'], 200);
    }

    // Method to display the update form
    public function edit($id)
    {
    
        $state = State::findOrFail($id);
        return view('state.edit', compact('state'));
    }

    // Method to update state data
    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);
        $state->state_name = $request->input('state_name');
        $state->status = $request->input('status');
        // Update other fields as needed

        $state->save();

        return redirect()->route('state.edit', $id)->with('success', 'State updated successfully');
    }

       // Method to update state data
    public function updateStatus(Request $request, $id)
    {
        $state = State::findOrFail($id);
        $state->status = $state->status == 'Active' ? 'Inactive' : 'Active';;
        // Update other fields as needed

        $state->save();

        return redirect()->route('district.edit', $id)->with('success', 'District updated successfully');
    }


  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $State = State::findOrFail($id);
  
        $State->delete();
  
        return redirect()->route('state')->with('success', 'State deleted successfully');
    }
}