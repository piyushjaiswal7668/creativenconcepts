<?php

namespace App\Http\Controllers\Chatify;

use App\Models\ChMessage as Message;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Chatify\Http\Controllers\MessagesController as BaseMessagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class MessagesController extends BaseMessagesController
{
    /**
     * Only show users with the 'user' role in the contacts list.
     */
    public function getContacts(Request $request)
    {
        $authId = Auth::user()->id;
        $roleUserIds = User::role('user')->pluck('id');

        // Subquery: get each conversation partner ID + latest message time.
        // Using IF() avoids selecting non-aggregated columns into GROUP BY.
        $partnerQuery = Message::selectRaw(
                "IF(from_id = ?, to_id, from_id) as partner_id, MAX(created_at) as max_created_at",
                [$authId]
            )
            ->where(function ($q) use ($authId) {
                $q->where('from_id', $authId)->orWhere('to_id', $authId);
            })
            ->groupBy('partner_id');

        $users = User::joinSub($partnerQuery, 'conversations', function ($join) {
                $join->on('users.id', '=', 'conversations.partner_id');
            })
            ->whereIn('users.id', $roleUserIds)
            ->select('users.*', 'conversations.max_created_at')
            ->orderBy('conversations.max_created_at', 'desc')
            ->paginate($request->per_page ?? $this->perPage);

        $usersList = $users->items();

        if (count($usersList) > 0) {
            $contacts = '';
            foreach ($usersList as $user) {
                $contacts .= Chatify::getContactItem($user);
            }
        } else {
            $contacts = '<p class="message-hint center-el"><span>Your contact list is empty</span></p>';
        }

        return Response::json([
            'contacts' => $contacts,
            'total'    => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }

    /**
     * Override to trim avatar path before Flysystem sees it.
     * Some rows in the DB were stored with a trailing tab character.
     */
    public function updateSettings(Request $request)
    {
        $msg = null;
        $error = $success = 0;

        if ($request['dark_mode']) {
            $request['dark_mode'] == 'dark'
                ? User::where('id', Auth::id())->update(['dark_mode' => 1])
                : User::where('id', Auth::id())->update(['dark_mode' => 0]);
        }

        if ($request['messengerColor']) {
            User::where('id', Auth::id())
                ->update(['messenger_color' => trim(filter_var($request['messengerColor']))]);
        }

        if ($request->hasFile('avatar')) {
            $allowed_images = Chatify::getAllowedImages();
            $file = $request->file('avatar');

            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed_images)) {
                    $currentAvatar = trim(Auth::user()->avatar ?? '');

                    // Persist the cleaned value in case it was corrupted
                    if ($currentAvatar !== (Auth::user()->avatar ?? '')) {
                        User::where('id', Auth::id())->update(['avatar' => $currentAvatar]);
                    }

                    if ($currentAvatar !== config('chatify.user_avatar.default')) {
                        if (Chatify::storage()->exists($currentAvatar)) {
                            Chatify::storage()->delete($currentAvatar);
                        }
                    }

                    $avatar = Str::uuid() . '.' . $file->extension();
                    $update = User::where('id', Auth::id())->update(['avatar' => $avatar]);
                    $file->storeAs(config('chatify.user_avatar.folder'), $avatar, config('chatify.storage_disk_name'));
                    $success = $update ? 1 : 0;
                } else {
                    $msg   = 'File extension not allowed!';
                    $error = 1;
                }
            } else {
                $msg   = 'File size you are trying to upload is too large!';
                $error = 1;
            }
        }

        return Response::json([
            'status'  => $success ? 1 : 0,
            'error'   => $error   ? 1 : 0,
            'message' => $error   ? $msg : 0,
        ], 200);
    }

    /**
     * Return just the name of a user by ID — used by the notification fallback on mobile.
     */
    public function userName(Request $request, $id)
    {
        $user = User::select('id', 'name')->find($id);
        return Response::json(['name' => $user?->name ?? '']);
    }

    /**
     * Only search users with the 'user' role.
     */
    public function search(Request $request)
    {
        $input = trim(filter_var($request['input']));

        $records = User::role('user')
            ->where('id', '!=', Auth::user()->id)
            ->where('name', 'LIKE', "%{$input}%")
            ->paginate($request->per_page ?? $this->perPage);

        $getRecords = null;
        foreach ($records->items() as $record) {
            $getRecords .= view('Chatify::layouts.listItem', [
                'get'  => 'search_item',
                'user' => Chatify::getUserWithAvatar($record),
            ])->render();
        }

        if ($records->total() < 1) {
            $getRecords = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }

        return Response::json([
            'records'   => $getRecords,
            'total'     => $records->total(),
            'last_page' => $records->lastPage(),
        ], 200);
    }
}
