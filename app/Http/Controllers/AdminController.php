<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $attributeCount = Attribute::count();
        $categoryCount = Category::count();
        $productCount = Product::count();

        //return view('admin.dashboard');
        return view('admin.dashboard', compact('attributeCount', 'categoryCount', 'productCount'));
    }

    public function users()
    {
        $users = User::where('role_id', '!=', 1)->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    public function addUser()
    {
        return view('admin.users.add');
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'status' => 'required',
            'name' => 'required',
            'role_id' => 'required'
        ]);
        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->status = $validatedData['status'];
        $user->role_id = $validatedData['role_id'];
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin.users')->with('success', 'New User added!');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' .$user->id,
            'status' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'role_id' => $request->role_id
        ]);

        if(isset($request->password) && $reqeust->password != '')
        {
            $user->update([
                'password' => bcrypt($request->user)  
            ]);
        }
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('delete', 'User deleted');   
    }

    
}
