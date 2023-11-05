<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Загружаем связанную модель Author
        $user = $request->user()->load('author');

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Валидация входных данных в форме запроса
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Обновляем данные пользователя (таблица users)
        $request->user()->save();

        // Если пользователь является Автором
        if( auth()->user()->role == 'admin' || auth()->user()->role == 'author') {
            // Получаем связанный экземпляр автора (таблица authors)
            $author = $request->user()->author();

            $authorData = [
                'user_id' => auth()->id(),
                'nickname' => $request->input('nickname'),
                'full_name' => $request->input('full_name'),
                'date_birth' => $request->input('date_birth'),
                'biography' => $request->input('biography'),
            ];

            $author->updateOrInsert([], $authorData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
