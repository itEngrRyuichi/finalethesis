<?php

namespace App\Http\Controllers;
use App\Accesscode;
use App\UserType;
use App\LeadTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AccesscodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getNewAccesscode(){

        function getOneDigit(){
            //Get Dicimal Value Randomly
            $OneDigit = rand(0,61);
            //Convert Dicimal to Base36
            if ($OneDigit == 10){
                $NewDigit = "A";
            } elseif($OneDigit == 11){
                $NewDigit = "B";
            } elseif($OneDigit == 12){
                $NewDigit = "C";
            } elseif($OneDigit == 13){
                $NewDigit = "D";
            } elseif($OneDigit == 14){
                $NewDigit = "E";
            } elseif($OneDigit == 15){
                $NewDigit = "F";
            } elseif($OneDigit == 16){
                $NewDigit = "G";
            } elseif($OneDigit == 17){
                $NewDigit = "H";
            } elseif($OneDigit == 18){
                $NewDigit = "I";
            } elseif($OneDigit == 19){
                $NewDigit = "J";
            } elseif($OneDigit == 20){
                $NewDigit = "K";
            } elseif($OneDigit == 21){
                $NewDigit = "L";
            } elseif($OneDigit == 22){
                $NewDigit = "M";
            } elseif($OneDigit == 23){
                $NewDigit = "N";
            } elseif($OneDigit == 24){
                $NewDigit = "O";
            } elseif($OneDigit == 25){
                $NewDigit = "P";
            } elseif($OneDigit == 26){
                $NewDigit = "Q";
            } elseif($OneDigit == 27){
                $NewDigit = "R";
            } elseif($OneDigit == 28){
                $NewDigit = "S";
            } elseif($OneDigit == 29){
                $NewDigit = "T";
            } elseif($OneDigit == 30){
                $NewDigit = "U";
            } elseif($OneDigit == 31){
                $NewDigit = "V";
            } elseif($OneDigit == 32){
                $NewDigit = "W";
            } elseif($OneDigit == 33){
                $NewDigit = "X";
            } elseif($OneDigit == 34){
                $NewDigit = "Y";
            } elseif($OneDigit == 35){
                $NewDigit = "Z";
            } elseif($OneDigit == 36){
                $NewDigit = "a";
            } elseif($OneDigit == 37){
                $NewDigit = "b";
            } elseif($OneDigit == 38){
                $NewDigit = "c";
            } elseif($OneDigit == 39){
                $NewDigit = "d";
            } elseif($OneDigit == 40){
                $NewDigit = "e";
            } elseif($OneDigit == 41){
                $NewDigit = "f";
            } elseif($OneDigit == 42){
                $NewDigit = "g";
            } elseif($OneDigit == 43){
                $NewDigit = "h";
            } elseif($OneDigit == 44){
                $NewDigit = "i";
            } elseif($OneDigit == 45){
                $NewDigit = "j";
            } elseif($OneDigit == 46){
                $NewDigit = "k";
            } elseif($OneDigit == 47){
                $NewDigit = "l";
            } elseif($OneDigit == 48){
                $NewDigit = "m";
            } elseif($OneDigit == 49){
                $NewDigit = "n";
            } elseif($OneDigit == 50){
                $NewDigit = "o";
            } elseif($OneDigit == 51){
                $NewDigit = "p";
            } elseif($OneDigit == 52){
                $NewDigit = "q";
            } elseif($OneDigit == 53){
                $NewDigit = "r";
            } elseif($OneDigit == 54){
                $NewDigit = "s";
            } elseif($OneDigit == 55){
                $NewDigit = "t";
            } elseif($OneDigit == 56){
                $NewDigit = "u";
            } elseif($OneDigit == 57){
                $NewDigit = "v";
            } elseif($OneDigit == 58){
                $NewDigit = "w";
            } elseif($OneDigit == 59){
                $NewDigit = "x";
            } elseif($OneDigit == 60){
                $NewDigit = "y";
            } elseif($OneDigit == 61){
                $NewDigit = "z";
            } else{
                $NewDigit = $OneDigit;
            }
            return $NewDigit;
        }
            
        $digit1 = getOneDigit();
        $digit2 = getOneDigit();
        $digit3 = getOneDigit();
        $digit4 = getOneDigit();
        $digit5 = getOneDigit();
        $digit6 = getOneDigit();
        $digit7 = getOneDigit();
        $digit8 = getOneDigit();
        
        $provisionalCode = $digit1.$digit2.$digit3.$digit4."-".$digit5.$digit6.$digit7.$digit8;

        $dataAccesscode = DB::table('accesscodes')
                            ->select('accesscodes.accesscode')
                            ->where('accesscode', '=', $provisionalCode)
                            ->get();

        if ($dataAccesscode == $provisionalCode) {
            $this->getNewAccesscode();
        }else{
            $NewAccesscode = $provisionalCode;
            return $NewAccesscode;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newCodes = $this->getNewAccesscode();
        $accesscodes = DB::table('user_types')
                    ->select('user_types.name', 'accesscodes.accesscode', 'accesscodes.allow_from', 'accesscodes.allow_to', 'lead_tos.id', 'lead_tos.lead_id')
                    ->join('lead_tos', 'lead_tos.lead_id', '=', 'user_types.id')
                    ->join('accesscodes', 'accesscodes.id', '=', 'lead_tos.access_id')
                    ->where('lead_tos.name', '=', 'account')
                    ->orderBy('lead_tos.lead_id', 'asc')
                    ->get();
        $now = Carbon::now();
        $now60 = Carbon::now()->addMinutes(60);
        return view('account.accountAccessCode',  ['accesscodes'=>$accesscodes, 'newCodes'=>$newCodes, 'now'=>$now, 'now60'=>$now60]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'accesscode' => 'required',
            'user_types' => 'required',
            'allow_from' => 'required',
            'allow_to' => 'required'
        ]);

        // Create New Accesscode
        // 1) Save New Accesscode to Accesscodes Table

        $accesscode = new Accesscode;
        $accesscode->accesscode = $request->input('accesscode');
        $accesscode->allow_from = $request->input('allow_from');
        $accesscode->allow_to = $request->input('allow_to');
        $accesscode->save();

        $leadTo = new LeadTo;
        $leadTo->name = "account";
        $leadTo->access_id = $accesscode->id;
        $leadTo->lead_id = $request->input('user_types');
        $leadTo->save();

        return redirect('/accountAccessCode')->with('success', 'Accesscode Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accesscode = LeadTo::find($id);
        $newCode = $this->getNewAccesscode();
        $accesscodes = DB::table('user_types')
                    ->select('user_types.name', 'accesscodes.accesscode', 'accesscodes.allow_from', 'accesscodes.allow_to', 'lead_tos.id')
                    ->join('lead_tos', 'lead_tos.lead_id', '=', 'user_types.id')
                    ->join('accesscodes', 'accesscodes.id', '=', 'lead_tos.access_id')
                    ->where('lead_tos.name', '=', 'account')
                    ->orderBy('lead_tos.created_at', 'desc')
                    ->get();
        return view('account.accountAccessCode',  ['accesscodes'=>$accesscodes, $newCode]);
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
        $this->validate($request, [
            'accesscode' => 'required',
            'user_types' => 'required',
            'allow_from' => 'required',
            'allow_to' => 'required'
        ]);

        // Create New Accesscode
        // 1) Save New Accesscode to Accesscodes Table

        $accesscode = Accesscode::where('accesscode', $request->input('accesscode'))->first();
        $accesscode->allow_from = $request->input('allow_from');
        $accesscode->allow_to = $request->input('allow_to');
        $accesscode->save();

        $leadTo = LeadTo::find($id);
        $leadTo->name = "account";
        $leadTo->access_id = $accesscode->id;
        $leadTo->lead_id = $request->input('user_types');
        $leadTo->save();

        return redirect('/accountAccessCode')->with('success', 'Accesscode Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accesscode = LeadTo::find($id);
        $accesscode->delete();
        return redirect('/accountAccessCode')->with('success', 'Accesscode Removed!');

    }
}
