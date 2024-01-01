<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, Response};

class PreferenceController extends Controller
{
    public function save(): Response|JsonResponse
    {
        $validatedData = $this->validate(request(), [
            'languages'    => ['array', 'min:1'],
            'sources'      => ['array', 'min:3'],
            'sources.*'    => ['numeric', 'exists:sources,id'],
            'categories'   => ['array', 'min:4'],
            'categories.*' => ['numeric', 'exists:categories,id'],
        ]);

        request()->user()
            ->preference()
            ->update([
                'languages'  => request('languages', []),
                'sources'    => request('sources', []),
                'categories' => request('categories', []),
            ]);

        return response()->json([
            'status'  => true,
            'message' => 'User Preferences saved Successfully',
            'user'    => auth()->user()->load('preference'),
        ], Response::HTTP_CREATED);
    }
}