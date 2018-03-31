<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Http\Request;

class Subscribe
{
    /**
     * Subscribe user and send Welcome message.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function subscribe($data)
    {
        $subscriber = Lead::create(['data' => json_encode(array_except($data, ['_token', 'submit']))]);

        return true;
    }

    /**
     * Unsuscribe user by field and value.
     *
     * @param string $field
     * @param string $value
     *
     * @return bool
     */
    public function unsubscribe($field, $value)
    {
        $leads = Lead::get();

        foreach ($leads as $lead) {
            $json = json_decode($lead->data);

            if (@$json->{$field} == $value) {
                $lead->delete();

                return true;
            }
        }

        return false;
    }
}
