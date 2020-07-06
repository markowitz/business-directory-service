<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = ['name', 'email', 'title', 'review', 'rate', 'listing_id'];

    protected $appends = ['gravatar_url'];
       /**
     * Attach avatar_url attrib to the User object
     *
     * @return string
     */
    public function getGravatarUrlAttribute()
    {
        // @todo: fetch full avatar url here
        // the full route to the avatar will be computed here
        $emailHash = md5(strtolower(trim($this->email)));
        $url = env('APP_URL')."/img/anon_user.jpg";
        return "https://www.gravatar.com/avatar/$emailHash?s=200&d=$url";
    }
}



