<?php

namespace App;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Fetch user projects.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members')->withPivot('amount');
    }

    /**
     * Fetch user tasks.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function tasks() {
        return $this->hasMany("App\Task")
                    ->orderBy('deadline', 'asc');
    }

    /**
     * Returns true if users are the same
     *
     * @var User
     * @return bool
     */
    public function checkUser(User $user) :bool
    {
        if ($this->is($user)) {
            return true;
        }

        return false;
    }

    /**
     * Delete user photo
     *
     * @return void
     */
    public function deletePhoto()
    {
        if ($this->hasPhoto()) {
            Storage::disk('public')->delete($this->photo);
            $this->photo = "user.png";
        }
    }

    /**
     * Returns true if user has a  photo
     *
     * @return bool
     */
    public function hasPhoto()
    {
        return $this->photo !== "user.png";
    }

    /**
     * Add photo in user profile
     *
     * @param string  $photo
     * @return void
     */
    public function setPhoto($photo)
    {
        if ($photo) {
            $this->deletePhoto();
            $this->photo = $photo;
        }
    }

    /**
     * Returns the number of user tasks
     *
     * @return int
     */
    public function countAllTasks()
    {
        return Task::where('user_id', $this->id)->count();
    }

    /**
     * Returns the number of user projects
     *
     * @return int
     */
    public function countAllProjects()
    {
        return Project::where('owner_id', $this->id)->count();
    }

    /**
     * Returns the number of active user projects
     *
     * @return int
     */
    public function countActiveProjects()
    {
        return Project::where([
            'owner_id'  => $this->id,
            'status'    => Project::ACTIVE
        ])->count();
    }

     /**
     * Fetch clients of the logged user
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getClients()
    {
        return Client::where('owner_id', auth()
            ->user()->id)
            ->get();
    }
}
