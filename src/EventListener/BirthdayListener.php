<?php


namespace App\EventListener;


use App\Event\BirthdayEvent;
use DateTime;

class BirthdayListener
{

    /**
     * @param BirthdayEvent $event
     */
    public function __invoke(BirthdayEvent $event)
    {
        $age = (new DateTime())->diff($event->getFriend()->getBirthdayDate())->y;
        $message = 'Today is ' . $event->getFriend()->getName() . '\'s birthday. ';
        $message .= 'Your friend is turning ' . $age . ' today, wish him well';

        $urls = explode(';', $_ENV['URLS']);

        $connection = curl_init();

        foreach ($urls as $url) {
            curl_setopt($connection, CURLOPT_URL, $url . '&msg=' . urlencode($message));
            curl_exec($connection);
        }

        curl_close($connection);

    }
}