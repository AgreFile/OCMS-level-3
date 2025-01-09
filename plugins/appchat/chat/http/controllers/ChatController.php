<?php
namespace AppChat\Chat\Http\Controllers;

use AppChat\Chat\Models\ChatRoom;
use AppChat\Chat\Models\Emoji;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Reaction;
use AppUser\User\Services\JwtService;
use Illuminate\Routing\Controller;
use AppUser\User\Models\User;
use Exception;
use DB;

class ChatController extends Controller
{
    public function CreateChat()
    {
        $userId = JwtService::GetUserIdFromCookie();
        $memberId = input("member");
        $RoomName = input("name") ? input("name") : "Chatroom";

        if (!$userId || !input("member")) {
            throw new Exception("Invalid Request", 400);
        }

        if (User::where("id", input("member"))->get()->isEmpty()) {
            throw new Exception("Invalid Request Member", 400);
        }

        if ($userId == $memberId) {
            throw new Exception("Invalid Request Member", 400);
        }

        $chatroom = new ChatRoom();
        $chatroom->room_name = $RoomName;
        $chatroom->save();

        $chatroom->users()->attach($userId);
        $chatroom->users()->attach($memberId);

        $chatroom->save();
        return response()->json(["chatroom" => $chatroom], 200);
    }

    public function SendMessage()
    {
        $userId = JwtService::GetUserIdFromCookie();
        $chatroomId = input("chatroom_id");
        $replyToMessageId = input("reply_to_message_id");

        $messageToReplyTo = Message::find($replyToMessageId);

        if (!$userId) {
            throw new Exception("Invalid user", 400);
        }
        if (!$chatroomId || ChatRoom::where("id", $chatroomId)->get()->isEmpty()) {
            throw new Exception("Chatroom doesn't exist", 400);
        }
        if (!empty($messageToReplyTo)) {
            if ($messageToReplyTo->chat_room_id != $chatroomId) {
                throw new Exception("invalid message to reply to", 400);
            }
        } 

        $newMessage = new Message();
        $newMessage->message = input("message");
        $newMessage->file_attacment = files("file");
        $newMessage->chat_room_id = $chatroomId;
        $newMessage->user_id = $userId;
        $newMessage->replying_to_message_id = $replyToMessageId;
        $newMessage->save();

        return response()->json([$newMessage], 200);
    }

    public function Chatrooms()
    {
        $chat_room = User::find(JwtService::GetUserIdFromCookie())->chat_rooms;
        return response()->json($chat_room, 200);
    }

    public function Messages()
    {
        $page = get("page");
        $chatroom_id = get("chatroom_id");

        $ChatroomMessages = ChatRoom::where("id", $chatroom_id)->first()->messages()->paginate(10, $page);

        $reactions = [];

        foreach ($ChatroomMessages as $message) {
            foreach (DB::table("reaction_message")->where("message_id", $message->id)->get() as $reaction) {
                $reactions[] = Reaction::find($reaction->reaction_id);
            }
        }

        return response()->json(["messages" => $ChatroomMessages, "reactions" => $reactions], 200);
    }

    public function ChangeChatRoomName()
    {
        $chatroom = ChatRoom::find(input("chatroom_id"));

        $chatroom->room_name = input("name");
        $chatroom->save();

        return response()->json($chatroom, 200);
    }

    //this gets all of the available emojis a user can react with
    public function Reactions()
    {
        return response()->json(["reactions" => Emoji::all()]);
    }

    public function ReactToAMessage()
    {
        $message = Message::find(input("message_id"));
        $emoji = Emoji::find(input("emoji_id"));

        if (!$emoji) {
            throw new Exception("invalid emoji", 400);
        }
        if (!$message) {
            throw new Exception("invalid messagee", 400);
        }

        // $reactionsToTheMessage = DB::table("reaction_message")->where("message_id", input("message_id"))->get();
        $reactionsToTheMessage = $message->reactions()->get();
        
        // return response($message->reactions()->get());

        if ($reactionsToTheMessage->isNotEmpty()) {
            foreach ($reactionsToTheMessage as $thisReaction) {
                if ($thisReaction->user_id == JwtService::GetUserIdFromCookie() || $thisReaction->emoji_id == input("emoji_id")) {
                    throw new Exception("Already reacted with the same emoji",400);
                }
            }
        }

        $reaction = new Reaction();
        $reaction->emoji_id = input("emoji_id");
        $reaction->user_id = JwtService::GetUserIdFromCookie();
        $reaction->save();

        $message->reactions()->attach($reaction);
        return $message;
    }
}