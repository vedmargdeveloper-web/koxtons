<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Redirect;


class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::orderBy('id', 'desc')->paginate(20);
        return view('gift.admin.redirect.index', compact('redirects'));
    }

    public function create()
    {
        return view('gift.admin.redirect.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'old_url' => 'required|string|max:255|unique:redirect,old_url',
            'new_url' => 'required|string|max:255',
            'status_code' => 'required|in:301,302',
        ]);

        Redirect::create($request->all());

        return redirect()->route('redirects.index')->with('success', 'Redirect created successfully.');
    }

    public function edit(Redirect $redirect)
    {
        return view('gift.admin.redirect.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $request->validate([
            'old_url' => 'required|string|max:255|unique:redirect,old_url,' . $redirect->id,
            'new_url' => 'required|string|max:255',
            'status_code' => 'required|in:301,302',
        ]);

        $redirect->update($request->all());

        return redirect()->route('redirects.index')->with('success', 'Redirect updated successfully.');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return redirect()->route('redirects.index')->with('success', 'Redirect deleted successfully.');
    }
}
