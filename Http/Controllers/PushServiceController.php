<?php

namespace Modules\PushService\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\PushService\Entities\PushService;
use Modules\PushService\Traits\PushServiceHelperTrait;
use Modules\PushService\Traits\FirebaseNotificationTrait;

class PushServiceController extends Controller
{
    use PushServiceHelperTrait, FirebaseNotificationTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['title'] = ___('pushService.push_service');
        $data['items'] = PushService::query();
        if($request->search != ""){
            $data['items'] =  $data['items']
                                ->where('name', 'like', '%' . $request->search . '%');
        }

        $data['items'] =  $data['items']->paginate(10);
        $data['create'] = ['route' => 'pushService.create', 'title' => ___('common.create'), 'icon' => 'fa fa-plus', 'permission' => 'push_service_create'];

        $data['actions']['delete'] = ['url' => 'pushservice/delete', 'title' => ___('common.delete'), 'icon' => 'fa fa-trash', 'permission' => 'push_service_delete'];
        return view('pushservice::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['users'] = User::VerifiedUser()->latest()->select('id','name','email')->get();
        $data['roles'] = Role::Active()->select('id', 'name')->get();
        $data['notification_types'] = ['announcement', 'reminder', 'notice'];
        $data['title'] = ___('pushService.new_push_service');
        $data['route'] = 'pushService.store';
        return view('pushservice::create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['danger'],  $validator->errors()->first());
        }
        try {
            //code...
            $pushable_type        = $request->receiver_type;
            $row                  = new PushService();
            $row->subject         = $request->subject;
            $row->description     = $request->description;
            $row->image           = $this->UploadImageCreate($request->image, 'backend/uploads/pushservice', 'path');
            $row->type            = $request->type;
            $row->pushable_type   = $pushable_type;
            $row->pushable_id     = $request->$pushable_type;
            $row->save();

            $this->sendChannelFirebaseNotification($pushable_type.'_'. $row->pushable_id, $row->type, '', '', $row->subject, $row->description, $row->image);
            return redirect()->route('pushService.index')->with('success', ___('alert.push_service_created_successfully'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withInput()->with(['danger'],  ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        if (PushService::destroy($request->id)) :
            $success[0] = "Deleted Successfully";
            $success[1] = "success";
            $success[2] = "Deleted";
        else :
            $success[0] = "Something went wrong, please try again.";
            $success[1] = 'error';
            $success[2] = "oops";
        endif;
        return response()->json($success);
    }
}
