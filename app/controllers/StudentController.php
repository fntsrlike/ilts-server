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

        $rules      = Config::get('validation.CTRL.student.apply_email_process.rules');
        $messages   = Config::get('validation.CTRL.student.apply_email_process.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);


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
                'unit'      => Config::get('sites.name'),
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

        $rules      = Config::get('validation.CTRL.student.apply_files_process.rules');
        $messages   = Config::get('validation.CTRL.studentapply_files_process.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

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
