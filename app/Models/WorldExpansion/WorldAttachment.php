<?php

namespace App\Models\WorldExpansion;

use App\Models\Item\Item;
use App\Models\Loot\Loot;
use App\Models\News;
use App\Models\Prompt\Prompt;
use Illuminate\Database\Eloquent\Model;

class WorldAttachment extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attacher_id', 'attacher_type', 'attachment_id', 'attachment_type', 'data',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'world_attachments';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the attachments.
     */
    public function attachment() {
        switch ($this->attachment_type) {
            case 'Figure':
                return $this->belongsTo(Figure::class, 'attachment_id');
            case 'Fauna':
                return $this->belongsTo(Fauna::class, 'attachment_id');
            case 'Flora':
                return $this->belongsTo(Flora::class, 'attachment_id');
            case 'Faction':
                return $this->belongsTo(Faction::class, 'attachment_id');
            case 'Concept':
                return $this->belongsTo(Concept::class, 'attachment_id');
            case 'Location':
                return $this->belongsTo(Location::class, 'attachment_id');
            case 'Event':
                return $this->belongsTo(Event::class, 'attachment_id');
            case 'Item':
                return $this->belongsTo(Item::class, 'attachment_id');
            case 'Prompt':
                return $this->belongsTo(Prompt::class, 'attachment_id');
            case 'News':
                return $this->belongsTo(News::class, 'attachment_id');
            case 'None':
                // Laravel requires a relationship instance to be returned (cannot return null), so returning one that doesn't exist here.
                return $this->belongsTo(Loot::class, 'attachment_id', 'loot_table_id')->whereNull('loot_table_id');
        }

        return null;
    }

    /**
     * Get the attachers.
     */
    public function attacher() {
        switch ($this->attacher_type) {
            case 'Figure':
                return $this->belongsTo(Figure::class, 'attacher_id');
            case 'Fauna':
                return $this->belongsTo(Fauna::class, 'attacher_id');
            case 'Flora':
                return $this->belongsTo(Flora::class, 'attacher_id');
            case 'Faction':
                return $this->belongsTo(Faction::class, 'attacher_id');
            case 'Concept':
                return $this->belongsTo(Concept::class, 'attacher_id');
            case 'Location':
                return $this->belongsTo(Location::class, 'attacher_id');
            case 'Event':
                return $this->belongsTo(Event::class, 'attacher_id');
            case 'Item':
                return $this->belongsTo(Item::class, 'attacher_id');
            case 'Prompt':
                return $this->belongsTo(Prompt::class, 'attacher_id');
            case 'News':
                return $this->belongsTo(News::class, 'attacher_id');
            case 'None':
                // Laravel requires a relationship instance to be returned (cannot return null), so returning one that doesn't exist here.
                return $this->belongsTo(Loot::class, 'attacher_id', 'loot_table_id')->whereNull('loot_table_id');
        }

        return null;
    }

    public function figures() {
        return $this->attachments()->where('attachment_type', 'Figure');
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/
}
