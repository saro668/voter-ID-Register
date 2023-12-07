<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\State;
use App\Models\District;

use Carbon\Carbon;
use DataTables;
use Mail;


 
class VotersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
        

            $data = Voter::select('voters.*', 'states.state_name', 'districts.district_name')
                ->join('states', 'voters.state_id', '=', 'states.id')
                ->join('districts', 'voters.district_id', '=', 'districts.id')
                ->orderBy('voters.created_at', 'DESC')
                ->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

       
        return view('voters.index');
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::where('status', 'Active')->get();
        $districts = District::where('status', 'Active')->get();

        return view('voters.create', compact('states', 'districts'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $eighteenYearsAgo = Carbon::now()->subYears(18)->format('Y-m-d');

        $request->validate([
            'first_name' => 'required|string|max:250',
            'last_name' => 'required|string|max:250',
            'mobile' => 'required|numeric|digits:10', 
            'email' => 'required|email|unique:voters,email', 
            'address' => 'required|string|max:255',
            'taluk' => 'required|string|max:100',
            'district_id' => 'required|integer',
            'state_id' => 'required|integer',
            'dob' => 'required|date|before_or_equal:' . $eighteenYearsAgo,
        ], 
        [
                'dob.before_or_equal' => 'You must be at least 18 years old.',
        ]);

      
        $model = Voter::create($request->all());

        
        // email data
        $email_data = [
            'name' => $request->input('first_name'),
            'email' => 'saravananr668@gmail.com',
            'unique_id' => $model->voter_identification_number,
            'currentDate' => Carbon::now()->toDateString(),
        ];

        // send email with the template
        Mail::send('mail.voter-register', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['name'])
                ->subject('Successfully Registered Your Voter ID')
                ->from('saravananr668@gmail.com', 'saravanan');
        });
    
 
        return response()->json(['msg' => 'Registered Successfully'], 200);
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $verify = Voter::findOrFail($id);

        $Voters = Voter::select('voters.*', 'states.state_name', 'districts.district_name')
                ->join('states', 'voters.state_id', '=', 'states.id')
                ->join('districts', 'voters.district_id', '=', 'districts.id')
                ->where('voters.id', $id)
                ->orderBy('voters.created_at', 'DESC')
                ->first();
  
        return view('voters.show', compact('Voters'));
    }
  
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Voters = Voter::findOrFail($id);
  
        $Voters->delete();
  
        return redirect()->route('voters')->with('success', 'Voters deleted successfully');
    }
}