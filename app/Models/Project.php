<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = []; 

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function clients() {
        return $this->belongsToMany(Client::class, 'project_client');
    }
    public function technologies() {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }
    public function media() {
        return $this->hasMany(Media::class);
    }
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}