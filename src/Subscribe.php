<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Http\Request;
use Mail;

class Subscribe
{
	/**
	 * Subscribe user and send Welcome message
	 * @param Illuminate\Http\Request $request 
	 * @return bool
	 */
	public function subscribe(Request $request)
	{
		$subscriber = Lead::create(['data' => json_encode($request->all())]);

		$setting = LeadSetting::first();

		Mail::send('admin::mail.welcome', ['setting' => $setting], function ($m) use ($subscriber, $setting, $request) {
            $m->from('noreply@'.$setting->mailer_name, $setting->mailer_name);

            $m->to($request->email, $request->full_name)->subject($setting->thank_you_subject);
        });

		return true;
	}

	/**
	 * Unsuscribe user by field and value
	 * @param string $field 
	 * @param string $value 
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
