<?php

    use RealRashid\SweetAlert\Facades\Alert;

    function secondsToTime($seconds) :string
    {
        $hours = floor($seconds / 3600);
        $seconds_left = $seconds - ($hours * 3600);
        $minutes = floor(($seconds_left / 60));
        $seconds_left = floor($seconds_left - ($minutes * 60));

        return $hours . "h " . $minutes . "m " . $seconds_left . "s";
    }

?>