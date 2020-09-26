<?php

namespace App\Http\Controllers;

use App\User;
use App\Subject;
use App\SubjectType;
use App\Clas;
use App\Accesscode;
use App\leadToClass;
use App\enrollment;
use App\task;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ClassCatalogController extends Controller
{

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
    public function index($id)
    {
        $newCodes = $this->getNewAccesscode();
        $now = Carbon::now();
        $now60 = Carbon::now()->addMinutes(60);
        $classLists = DB::table('classes')
                    ->select(
                        'classes.id as class_id',
                        'classes.stubcode',
                        'classes.coursecode',
                        'classes.progress',
                        'classes.classPic_location',
                        'classes.subject_id',
                        'subjects.name as subject_name',
                        'subjects.gradeLevel',
                        'classes.schoolYear_id',
                        'school_years.name as schoolYear',
                        'classes.semester_id',
                        'semesters.name as semester',
                        'lead_to_classes.lead_id',
                        'lead_to_classes.access_id',
                        'accesscodes.accesscode',
                        'accesscodes.allow_from',
                        'accesscodes.allow_to'
                        )
                    ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
                    ->leftJoin('school_years', 'classes.schoolYear_id', '=', 'school_years.id')
                    ->leftJoin('semesters', 'classes.semester_id', '=', 'semesters.id')
                    ->leftJoin('lead_to_classes', 'classes.id', '=', 'lead_to_classes.lead_id')
                    ->leftJoin('accesscodes', 'lead_to_classes.access_id', '=', 'accesscodes.id')
                    ->orderBy('classes.stubcode')
                    ->where('classes.subject_id', '=', $id)
                    ->get();
        $subjectID = $id;
        return view('class.classCatalog', ['classLists' => $classLists,  'subjectID' => $subjectID, 'newCodes'=>$newCodes, 'now'=>$now, 'now60'=>$now60]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'allow_from' => 'required',
            'allow_to' => 'required',
            'subject_id' => 'required',
            'stubcode' => 'required|numeric',
            'coursecode' => 'required',
            'schoolYear_id' => 'required',
            'semester_id' => 'required',
            'classPic_location' => 'image|nullable|max:1999',
        ]);

        // Handle File Upload
        if ($request->hasFile('classPic_location')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('classPic_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('classPic_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('classPic_location')->storeAs('public/images/class', $fileNameToStore);
        } else{
            $fileNameToStore = 'default-class-pic.jpg';
        }

        $class = new Clas;
        $class->subject_id = $request->input('subject_id');
        $class->stubcode = $request->input('stubcode');
        $class->coursecode = $request->input('coursecode');
        $class->schoolYear_id = $request->input('schoolYear_id');
        $class->semester_id = $request->input('semester_id');
        $class->classPic_location = $fileNameToStore;
        $class->progress = $request->input('progress');
        $class->save();

        $accesscode = new Accesscode;
        $accesscode->accesscode = $request->input('accesscode');
        $accesscode->allow_from = $request->input('allow_from');
        $accesscode->allow_to = $request->input('allow_to');
        $accesscode->save();

        $leadToClass = new leadToClass;
        $leadToClass->name = "class";
        $leadToClass->access_id = $accesscode->id;
        $leadToClass->lead_id = $class->id;
        $leadToClass->save();

        //Auto Enroll for Teacher
        $teacherEnroll = new enrollment;
        $teacherEnroll->user_id = Auth::user()->id;
        $teacherEnroll->class_id = $class->id;
        $teacherEnroll->save();

        //Auto Create Attendance
        $Onequarters = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class->id]
                            ])
                        ->skip(0)->take(1)->get();
        $Twoquarters = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class->id]
                            ])
                        ->skip(1)->take(1)->get();
        $TwoComponents = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class->id]
                            ])
                        ->skip(1)->take(1)->get();
        //--------1st Quarter----------
        $OneTask = new task;
        $OneTask->class_id = $class->id;
        $OneTask->quarter_id = $Onequarters->pluck("quarter_id")->first();
        $OneTask->component_id = $TwoComponents->pluck("component_id")->first();
        $OneTask->task_type = "attendance";
        $OneTask->name = "Attendance of ".$Onequarters->pluck("quarter_name")->first();
        $OneTask->hps = "100";
        $OneTask->save();
        
        $addOneAttendance = new Attendance;
        $addOneAttendance->task_id = $OneTask->id;
        $addOneAttendance->totalAttendance = "100";
        $addOneAttendance->save();

        //--------12nd Quarter----------
        $TwoTask = new task;
        $TwoTask->class_id = $class->id;
        $TwoTask->quarter_id = $Twoquarters->pluck("quarter_id")->first();
        $TwoTask->component_id = $TwoComponents->pluck("component_id")->first();
        $TwoTask->task_type = "attendance";
        $TwoTask->name = "Attendance of ".$Twoquarters->pluck("quarter_name")->first();
        $TwoTask->hps = "100";
        $TwoTask->save();

        $addTwoAttendance = new Attendance;
        $addTwoAttendance->task_id = $TwoTask->id;
        $addTwoAttendance->totalAttendance = "100";
        $addTwoAttendance->save();


        return redirect('/classCatalog'.'/'.$request->input('subject_id'))->with('success', 'class Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'allow_from' => 'required',
            'allow_to' => 'required',
            'subject_id' => 'required',
            'stubcode' => 'required|numeric',
            'coursecode' => 'required',
            'schoolYear_id' => 'required',
            'semester_id' => 'required',
        ]);

        // Handle File Upload
        if ($request->hasFile('classPic_location')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('classPic_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('classPic_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('classPic_location')->storeAs('public/images/class', $fileNameToStore);
        }

        $class = Clas::find($id);
        if ($request->hasFile('classPic_location')){
            $class->classPic_location = $fileNameToStore;
        }
        $class->subject_id = $request->input('subject_id');
        $class->stubcode = $request->input('stubcode');
        $class->coursecode = $request->input('coursecode');
        $class->schoolYear_id = $request->input('schoolYear_id');
        $class->semester_id = $request->input('semester_id');
        $class->progress = $request->input('progress');
        $class->save();

        $accesscode = Accesscode::where('accesscode', $request->input('accesscode'))->first();                                                                    
        $accesscode->allow_from = $request->input('allow_from');
        $accesscode->allow_to = $request->input('allow_to');
        $accesscode->save();

        return redirect('/classCatalog'.'/'.$request->input('subject_id'))->with('success', 'class Updated!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Clas::find($id);
        $leadToclass = leadToclass::where('lead_id', $id)->first();
        $ltsID = $leadToclass->access_id;
        $accesscode = Accesscode::where('id', $ltsID)->first();
        if($class->classPic_location != 'default-class-pic.jpg'){
            // Delete Image
            Storage::delete('public/storage/images/class/'.$class->classPic_location);
        }
        $accesscode->delete();
        $class->delete();
        $leadToclass->delete();
        return redirect('/subjectCatalog')->with('success', 'Class Removed!');
    }
}
