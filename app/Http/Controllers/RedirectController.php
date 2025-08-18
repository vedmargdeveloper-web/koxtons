<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Redirect;


class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::orderBy('id', 'desc')->paginate(20);
        return view('gift.admin.redirects.index', compact('redirects'));
    }

    public function create()
    {
        return view('gift.admin.redirects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'old_url' => 'required|string|max:255|unique:redirects,old_url',
            'new_url' => 'required|string|max:255',
            'status_code' => 'required|in:301,302',
        ]);

        Redirect::create($request->all());

        return redirect()->route('redirects.index')->with('success', 'Redirect created successfully.');
    }

    public function edit(Redirect $redirect)
    {
        return view('gift.admin.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $request->validate([
            'old_url' => 'required|string|max:255|unique:redirects,old_url,' . $redirect->id,
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
