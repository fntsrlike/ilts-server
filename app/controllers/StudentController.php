<?php
class StudentController extends BaseController {

    protected $layout = 'master';

    public function __construct() {

    }

    public function apply_email() {

        return View::make('student/apply_form_email');

    }

    public function apply_files() {



        $data['depart'] = Config::get('nchu.departments');
        $data['grade']  = Config::get('nchu.grades');

        return View::make('student/apply_form_files', $data);
    }

    public function apply_email_process() {

        $this->beforeFilter('csrf', array('on' => 'post'));

        $rules = array(
            'email'         => array('required', 'email', 'regex:/^[a-zA-Z0-9._-]+@mail\.[a-zA-Z0-9.-]+\.edu\.tw$/', 'unique:ilt_user_students,email')
        );

        $messages = array(
            'email.required'        => '學校信箱欄位必須填寫！',
            'email.email'           => '學校信箱欄位必須是正常的email格式',
            'email.regex'           => '學校信箱欄位必須以@mail.xxx.edu.tw為位址。',
            'email.unique'          => '本學校信箱已經認證過了！',
        );

        $validator = Validator::make(Input::all(), $rules, $messages);


        if ($validator->fails()) {
            return Redirect::action('StudentController@apply_email')->withErrors($validator)->withInput();
        }
        else {
            $username = Session::get('user_being.username');
            $code = md5( time() + $username );

            $email = new IltEmailVallisations;
            $email->u_id    = Session::get('user_being.u_id');
            $email->type    = 'student';
            $email->code    = $code;
            $email->email   = input::get('email');
            $email->expires = date('Y-m-d', time() + 3 * 24 * 3600);
            $email->save();

            $data = array(
                'username'  => $username,
                'unit'      => '幼稚鬼團',
                'link'      => action( 'UserController@email_vallidate', array('student', $code) )
            );

            Mail::send('student.email_vallidation_mail', $data, function($message)
            {
                $message
                ->to( Input::get('email'), Session::get('user_being.username') )
                ->subject('伊爾特系統 學生身份確認信');
            });

            return View::make('student/apply_email_success');
        }
    }

    public function apply_files_process() {


        $student_orm = IltUserStudent::where('u_id', '=', Session::get('user_being.u_id'))->first();

        if ( $student_orm === null ) {
            return Redirect::action('StudentController@apply_email');
        }

        $this->beforeFilter('csrf', array('on' => 'post'));

        $rules = array(
            'number'        => 'required|numeric|min:1000000000|max:9999999999',
            'department'    => array('required', 'regex:/^[A-Z][0-9]{2}[A-C]?$/'),
            'grade'         => 'required|numeric|between:0,6',
        );

        $messages = array(
            'number.required'       => '學號欄位必須填寫！',
            'number.numeric'        => '學號欄位只能填寫數字！',
            'number.min'            => '學號欄位必須填寫十碼！',
            'number.max'            => '學號欄位必須填寫十碼！',
            'department.required'   => '科系欄位必須填寫！',
            'department.regex'      => '科系欄位代號有誤！',
            'grade.required'        => '年級欄位必須填寫！',
            'grade.numeric'         => '年級欄位只能填寫數字！',
            'grade.between'         => '年級欄位的範圍有誤！',
        );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::action('UserController@apply_student')->withErrors($validator)->withInput();
        }
        else {

            $user    = IltUser::find(Session::get(Session::get('user_being.u_id')));
            $student = IltUserStudent::where('u_id', '=', Session::get('user_being.u_id'))->first();

            $student->number     = Input::get('number');
            $student->department = Input::get('department');
            $student->grade      = Input::get('grade');
            $student->is_valid   = 1;
            $student->save();

            $user = IltUser::find(Session::get('user_being.u_id'));

            if( empty($user->u_authority) ) {
                $user->u_authority = 'STUDENT';
            }
            else {
                $user->u_authority .= ',STUDENT';
            }

            $user->save();

            return View::make('student/apply_files_success');
        }
    }
}