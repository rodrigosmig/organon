<?php

    use RealRashid\SweetAlert\Facades\Alert;

    function getFormFailMessages(Array $messages) :string
    {
        $fail_messages = "";
        foreach ($messages as $message) {
            $fail_messages .= $message . "\n";
        }
        
        Alert::warning(__('Warning'), $fail_messages)->autoclose(10000);
        
        return $fail_messages;
    }

?>