<?php

namespace App\Models\WorldExpansion;

use App\Models\Character\Character;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class FactionRankMember extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faction_id', 'rank_id', 'member_type', 'member_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faction_rank_members';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the faction this member belongs to.
     */
    public function faction() {
        return $this->belongsTo(Faction::class, 'faction_id');
    }

    /**
     * Get the rank this member belongs to.
     */
    public function rank() {
        return $this->belongsTo(FactionRank::class, 'rank_id');
    }

    /**
     * Get the associated figure.
     */
    public function figure() {
        return $this->belongsTo(Figure::class, 'member_id');
    }

    /**
     * Get the associated user.
     */
    public function user() {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Get the associated character.
     */
    public function character() {
        return $this->belongsTo(Character::class, 'member_id');
    }

    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/

    /**
     * Gets the member object depending on member type.
     *
     * @return Character|Figure|User
     */
    public function getMemberObjectAttribute() {
        switch ($this->member_type) {
            case 'figure':
                return $this->figure;
                break;
            case 'user':
                return $this->user;
                break;
            case 'character':
                return $this->character;
                break;
        }
    }
}
