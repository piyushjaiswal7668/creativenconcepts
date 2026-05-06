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
