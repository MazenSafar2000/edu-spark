<?

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessagesRead implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $userId;      // المستلم (Auth::id())
    public $fromId;      // المرسل
    public $totalUnread; // كل الرسائل الغير مقروءة
    public $userUnread;  // الرسائل الغير مقروءة من هذا المرسل فقط

    public function __construct($userId, $fromId, $totalUnread, $userUnread)
    {
        $this->userId      = $userId;
        $this->fromId      = $fromId;
        $this->totalUnread = $totalUnread;
        $this->userUnread  = $userUnread;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chatify.{$this->userId}");
    }

    public function broadcastAs()
    {
        return 'messages.read';
    }
}
