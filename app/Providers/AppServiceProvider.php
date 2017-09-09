<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Event;
use App\Confirmation;
use App\Accomodation;
use Auth;
use App\Traits\Utilities;
use Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    use Utilities;

    public function boot()
    {

        view()->composer('layouts.admin', function($view){
            $new_requests = Confirmation::all()->where('status', null)->where('file_name', '<>', null)->count();
            $new_accomodations = Accomodation::all()->where('status', null)->count();
            $view->with('new_requests', $new_requests)->with('new_accomodations', $new_accomodations);            
        });
        Validator::extend('samePassword', function($attribute, $value, $parameters, $validator){
            $old_password_hash = $parameters[0];
            if(Hash::check($value, $old_password_hash)){
                return true;                
            }
            else{
                return false;
            }
        });
        Validator::replacer('samePassword', function($message, $attribute, $rule, $parameters, $validator){
            return "Your old password is wrong";
        });
        // Validator for checking if the admin exist
        Validator::extend('adminExists', function($attribute, $value, $parameters, $validator){
            $admin_emails = explode(',', $value);
            foreach($admin_emails as $admin_email){
                if(User::where('type', 'admin')->where('email', $admin_email)->count() == 0){
                    return false;
                }
            }
            return true;
        });
        Validator::replacer('adminExists', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $admin_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($admin_emails as $admin_email){
                if(User::where('type', 'admin')->where('email', $admin_email)->count() == 0){
                    array_push($invalid_emails, $admin_email);
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails is/are not registered as admins');
        });
        // Validator for checking team members have registered
        Validator::extend('teamMembersExist', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);
            foreach($team_members_emails as $team_member_email){
                if(User::where('email', $team_member_email)->count() == 0){
                    return false;
                }
            }
            return true;
        });
        Validator::replacer('teamMembersExist', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($team_members_emails as $team_member_email){
                if(User::where('email', $team_member_email)->count() == 0){
                    array_push($invalid_emails, $team_member_email);
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails has/have not registered yet');
        });
        // Validator for checking team members have registered
        Validator::extend('isParticipating', function($attribute, $value, $parameters, $validator){
            $user = User::find($value);
            $event = Event::find($parameters[0]);
            if($event->isGroupEvent()){
                if(!$user->teamLeaderFor($event->id)){
                    return false;
                }
            }
            else{
                if(!$user->isParticipating($event->id)){
                    return false;
                }
            }
            return true;
        });
        Validator::replacer('isParticipating', function($message, $attribute, $rule, $parameters, $validator){
            $event = Event::find($parameters[0]);
            $value = array_get($validator->getData(), $attribute);            
            if($event->isGroupEvent()){
                return str_replace(':invalid_ids', $value, 'LG:invalid_ids is not a team leader participating in this event');            
            }   
            else{
                return str_replace(':invalid_ids', $value, 'LLG:invalid_ids is not participating in this event');                            
            }         
        });
        // Validator for checking team members are from same college
        Validator::extend('isCollegeMate', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    $user_college = Auth::user()->college;
                    $team_member_college = $team_member->college;
                    if($team_member_college->id != $user_college->id){
                        return false;
                    }
                }
            }
            return true;
        });
        Validator::replacer('isCollegeMate', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();                
                if($team_member){
                    $user_college = Auth::user()->college;
                    $team_member_college = $team_member->college;
                    if($team_member_college->id != $user_college->id){
                        array_push($invalid_emails, $team_member_email);                        
                    }
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails is/are not from your college');
        });
        // Validator for checking team members have not confirmed registrations        
        Validator::extend('isNotConfirmed', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    if($team_member->hasConfirmed()){
                        return false;
                    }
                }
            }
            return true;
        });
        Validator::replacer('isNotConfirmed', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    if($team_member->hasConfirmed()){
                        array_push($invalid_emails, $team_member->email);
                    }
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails has/have already confirmed registration');
        });
        // Validator for checking team members have no parallel events        
        Validator::extend('hasNoParallelEvent', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    if($this->userHasParallelEvent($team_member->id, $parameters[0])){
                        return false;
                    }
                }
            }
            return true;
        });
        Validator::replacer('hasNoParallelEvent', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    if($this->userHasParallelEvent($team_member->id, $parameters[0])){
                        array_push($invalid_emails, $team_member->email);
                    }
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails has/have registered parallel events');
        });
        // Validator for checking number of team members is within the min and max limit
        Validator::extend('teamMembersCount', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);
            $event = Event::find($parameters[0]);            
            $team_members = 0;
            foreach($team_members_emails as $team_member_email){
                $team_members++;
            }
            // max and min members excluding the team leader
            $max_members  = $event->max_members-1;
            $min_members  = $event->min_members-1;   
            if($team_members < $min_members || $team_members > $max_members){
                return false;
            }
            else{
                return true;                
            }
        });
        Validator::replacer('teamMembersCount', function($message, $attribute, $rule, $parameters, $validator){
            $event = Event::find($parameters[0]);
            if($event->min_members == $event->max_members){
                return str_replace(':event_name', $event->title, ":event_name requires exactly $event->max_members participants");  
            }
            return str_replace(':event_name', $event->title, ":event_name requires minimum $event->min_members and maximum of $event->max_members participants");
        });
        Validator::extend('noTeamLeader', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);       
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member && Auth::user()->id == $team_member->id){
                    return false;
                }
            }
            return true;
        });
        Validator::replacer('noTeamLeader', function($message, $attribute, $rule, $parameters, $validator){
            return "Team leader email should not be included";
        });
        Validator::extend('hasActivated', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);       
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member && !$team_member->hasActivated()){
                    return false;
                }
            }
            return true;
        });
        Validator::replacer('hasActivated', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $invalid_emails = [];
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member){
                    if(!$team_member->hasActivated()){
                        array_push($invalid_emails, $team_member->email);
                    }
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails has/have not activated account');
        });
        Validator::extend('checkGenderMixing', function($attribute, $value, $parameters, $validator){
            $team_members_emails = explode(',', $value);   
            $user_gender = Auth::user()->gender;
            $event = Event::find($parameters[0]);
            if($event->allow_gender_mixing){
                return true;
            }
            else{
                foreach($team_members_emails as $team_member_email){
                    $team_member = User::where('email', $team_member_email)->first();
                    if($team_member && $team_member->gender != $user_gender){
                        return false;
                    }
                }
            }
            return true;
        });
        Validator::replacer('checkGenderMixing', function($message, $attribute, $rule, $parameters, $validator){
            $value = array_get($validator->getData(), $attribute);
            $team_members_emails = explode(',', $value);
            $user_gender = Auth::user()->gender;            
            $invalid_emails = [];
            $event = Event::find($parameters[0]);
            foreach($team_members_emails as $team_member_email){
                $team_member = User::where('email', $team_member_email)->first();
                if($team_member && $team_member->gender != $user_gender){
                    array_push($invalid_emails, $team_member->email);
                }
            }
            $invalid_emails = implode(',', $invalid_emails);
            return str_replace(':invalid_emails', $invalid_emails, ':invalid_emails is/are not allowed as this event does not allow mixing of genders');
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
