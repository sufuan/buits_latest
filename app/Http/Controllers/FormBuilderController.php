<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormBuilderController extends Controller
{
    public $user;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



    public function index()
    {
        if (is_null($this->user) || !$this->user->can('forms.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any forms !');
        }


        $forms = FormBuilder::all();
        return view('backend/pages/FormBuilder.index', compact('forms'));
    }

    public function create(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('forms.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any forms !');
        }


        $item = new FormBuilder();
        $item->name = $request->name;
        $item->content = $request->form;
        $item->save();

        return response()->json('added successfully');
    }

    public function editData(Request $request)
    {


        if (is_null($this->user) || !$this->user->can('forms.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any forms !');
        }


        return FormBuilder::where('id', $request->id)->first();
    }

    public function update(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('forms.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any forms !');
        }


        $item = FormBuilder::findOrFail($request->id);
        $item->name = $request->name;
        $item->content = $request->form;
        $item->update();
        return response()->json('updated successfully');
    }

    public function destroy($id)
    {

        if (is_null($this->user) || !$this->user->can('forms.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any forms !');
        }


        $form = FormBuilder::findOrFail($id);
        $form->delete();

        return redirect('admin/form-builder')->with('success', 'Form deleted successfully');
    }
}
