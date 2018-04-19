@lang('admin.dear') {{$name}}, <br/>
@lang('admin.msgMainInResetPassEmail')<br/>

<a href="{{route('password.update.view', array($id, $code))}}">{{route("password.update.view",array($id,$code))}}</a><br/>
@lang('admin.msgApologizeInResetPassEmail') <br/>
Thank you!