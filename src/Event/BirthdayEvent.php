<?php


namespace App\Event;
use App\Entity\Friend;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BirthdayEvent
 * @package App\Event
 */
class BirthdayEvent extends Event
{
    public CONST NAME = 'birthday.event';

    /** @var Friend $friend */
    protected $friend;

    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    /**
     * @return Friend
     */
    public function getFriend(): Friend
    {
        return $this->friend;
    }
}