<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Facades\FormatFacade;
use App\Invoice;
use App\User;
use App\UserGoal;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Notifications\UserRoleSetNotification;
use Validator;

class UserController extends AdminController
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {

        return Datatables::of(User::all())->make(true);
    }

    public function show($id)
    {
    }

    public function create(Request $request)
    {
        $user = new User();

        return view('user.create', ['user' => $user]);
    }

    public function store($id)
    {
    }

    public function edit($id)
    {
        $user = User::find($id);
        $total_deals = Deal::where('owner_id', $user->id);

        $unpaid = Invoice::where('owner_id', $user->id)->where('status', '0');
        $earned = Invoice::where('owner_id', $user->id)->where('total_received', '>', 0);

        return view('user.edit', [
            'user' => $user,
            'total_deals' => FormatFacade::getNumberWithUnit($total_deals->count()),
            'earned' => FormatFacade::getNumberWithUnit($earned->sum('total_received')),
            'unpaid' => FormatFacade::getNumberWithUnit($unpaid->count())
        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user_roles = Config::get('constants.users.user_roles');
        $user_role = $request->input('user_role', $user_roles['manager']);
        $activated = filter_var($request->input('activated', 'false'), FILTER_VALIDATE_BOOLEAN);

        $prev_user_role = $user->user_role;
        $prev_activated = $user->activated;

        $user->fill([
            'user_role' => $user_role,
            'activated' => $activated,
        ]);

        $ret = $user->save();

        if ($ret == true) {
            if ($prev_user_role != $user_role) {
                $user->notify(new UserRoleSetNotification());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User has been updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 'danger',
                'message' => 'User could not be updated.',
            ]);
        }
    }

    public function updateGoal($user_id, Request $request) {
        $user = User::find($user_id);
        
        $id = $request->get('id', 0);
        if (empty($id)) {
            $validation_rules = [
                'season' => 'required',
                'goal_amount' => 'required|numeric',
            ];
        } else {
            $validation_rules = [
                'goal_amount' => 'required|numeric',
            ];
        }
        
        $data = $request->only(['season', 'goal_amount']);
        $validator = Validator::make($data, $validation_rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'danger',
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }
        
        if(empty($id)) {
            try {
                $user_goal = UserGoal::create([
                    'season_start_at' => $data['season'],
                    'season_end_at' => $data['season'] + 1,
                    'goal_amount' => $data['goal_amount'],
                    'user_id' => $user->id,
                ]);
            } catch(\Exception $e) {
                return response()->json([
                    'status' => 'danger',
                    'errors' => [
                        'season' => ['User Goal is duplicated.'],
                    ]
                ], 400);
            }
        } else {
            $user_goal = UserGoal::find($id);
            if($user_goal == null) {
                return response()->json([
                    'status' => 'danger',
                    'errors' => [
                        'season' => ['User Goal is duplicated.'],
                    ]
                ], 400);
            }
            try {
                $user_goal->fill([
                    'goal_amount' => $data['goal_amount']
                ]);
                $user_goal->save();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'danger',
                    'errors' => [
                        'start_season' => ['Internel Server Error!'],
                    ]
                ]);
            }
        }
        return view('user.goal-show', ['user' => $user]);
    }

    public function destroyGoal($user_id, Request $request) {
        $id = $request->input('id');
        $ret = UserGoal::destroy($id);
        if ($ret > 0) {
            $user = User::find($user_id);
            return view('user.goal-show', ['user' => $user]);
        }
        return response()->json([
            'status' => 'danger',
            'message' => 'User Goal could not be deleted.',
        ], 400);
        
    }

    public function destroy($id)
    {
        $ret = User::destroy($id);
        if ($ret > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has been deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 'danger',
                'message' => 'User could not be deleted.',
            ]);
        }
    }
}
