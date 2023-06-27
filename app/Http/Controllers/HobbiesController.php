<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHobbiesRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\Hobbies;
use App\Models\User;
use App\Models\UserHobbies;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class HobbiesController extends Controller
{
    public function index()
    {
        $hobbies = Hobbies::all();
        return view('user-hobbies', compact('hobbies'));
    }

    public function create(UserCreateRequest $request)
    {
        $userId = User::create(['first_name' => $request->first_name, 'last_name' => $request->last_name]);
        $request['user_id'] = $userId;
        $hobbies = $request->only(['hobbbies']);
        $hobbies = $hobbies['hobbbies'];
        foreach ($hobbies as $hobbie) {
            UserHobbies::create(['user_id' => $userId['id'], 'hobbies_id' => $hobbie]);
        }
        return redirect()->back();
    }

    public function hobbies(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('userHobbies:id,hobbie_name')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . url('update', encrypt($row->id)) . '"   class="edit btn btn-primary btn-sm">Edit</a> <a href="' . url('delete', encrypt($row->id)) . '" class="edit btn btn-primary btn-sm">Delete</a>';
                    return $btn;
                })

                ->addColumn('hobbies', function ($data) {
                    $hobbiesArray = array();
                    foreach ($data->userHobbies as $hobbies) {
                        $hobbiesArray[] = $hobbies->hobbie_name;
                    }
                    return $hobbies = implode(',', $hobbiesArray);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user-hobbies-view');
    }

    public function update($userId)
    {
        $user = User::find(decrypt($userId));
        $existingHobbies = $user->userHobbies->pluck('hobbie_name')->toArray();
        $hobbies = Hobbies::all();
        return view('user-hobbies-update', compact('hobbies', 'existingHobbies', 'user'));
    }

    public function delete($userId)
    {
        UserHobbies::where('user_id', decrypt($userId))->delete();
        User::where('id', decrypt($userId))->delete();
        return redirect()->back();
    }

    public function updatePost(UpdateHobbiesRequest $request)
    {
        User::where('id', $request->user_id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name]);
        $hobbies = $request->only(['hobbbies']);
        $hobbies = $hobbies['hobbbies'];
        UserHobbies::where('user_id', $request->user_id)->whereNotIn('hobbies_id', $hobbies)->delete();
        foreach ($hobbies as $hobbie) {
            UserHobbies::updateOrCreate(['user_id' => $request->user_id, 'hobbies_id' => $hobbie]);
        }
        return redirect()->back();
    }
}
