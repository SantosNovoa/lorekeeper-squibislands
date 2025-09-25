<?php

namespace App\Services\WorldExpansion;

use App\Models\Item\Item;
use App\Models\WorldExpansion\Fauna;
use App\Models\WorldExpansion\Flora;
use App\Models\WorldExpansion\Location;
use App\Models\WorldExpansion\WorldAttachment;
use App\Services\Service;

class WorldExpansionService extends Service {
    /*
    |--------------------------------------------------------------------------
    | WorldExpansion Service
    |--------------------------------------------------------------------------
    |
    | Handles the various functions used by multiple world expansion models.
    |
    */

    /**
     * Creates a new fauna category.
     *
     * @param array $data
     * @param mixed $model
     *
     * @return \App\Models\Fauna\Category|bool
     */
    public function updateAttachments($model, $data) {
        // Determine if there are attachments added.
        $attachments = [];
        if (isset($data['attachment_id'])) {
            foreach ($data['attachment_id'] as $key => $attachment_id) {
                if (!isset($data['attachment_type'][$key])) {
                    continue;
                }
                switch ($data['attachment_type'][$key]) {
                    case 'Item':        $attach = Item::find((int) $attachment_id);
                        break;
                    case 'News':        $attach = \App\Models\News::find((int) $attachment_id);
                        break;
                    case 'Prompt':      $attach = \App\Models\Prompt\Prompt::find((int) $attachment_id);
                        break;

                    case 'Figure':      $attach = \App\Models\WorldExpansion\Figure::find((int) $attachment_id);
                        break;
                    case 'Fauna':       $attach = Fauna::find((int) $attachment_id);
                        break;
                    case 'Flora':       $attach = Flora::find((int) $attachment_id);
                        break;
                    case 'Faction':     $attach = \App\Models\WorldExpansion\Faction::find((int) $attachment_id);
                        break;
                    case 'Concept':     $attach = \App\Models\WorldExpansion\Concept::find((int) $attachment_id);
                        break;
                    case 'Event':       $attach = \App\Models\WorldExpansion\Event::find((int) $attachment_id);
                        break;
                    case 'Location':    $attach = Location::find((int) $attachment_id);
                        break;

                    default:            $attach = null;
                }
                if (!$attach) {
                    continue;
                }  // Quietly ignore
                $attachments[] = [
                    'attachment'    => $attach,
                    'type'          => $data['attachment_type'][$key],
                    'data'          => $data['attachment_data'][$key] ?? null,
                ];
            }
        }

        // Remove all attachments from the model so they can be reattached with new data
        WorldAttachment::where('attacher_type', class_basename($model))->where('attacher_id', $model->id)->delete();

        // Attach any attachments to the model
        foreach ($attachments as $attachment) {
            WorldAttachment::create([
                'attacher_id'       => $model->id,
                'attacher_type'     => class_basename($model),
                'attachment_id'     => $attachment['attachment']->id,
                'attachment_type'   => $attachment['type'],
                'data'              => $attachment['data'],
            ]);
        }
    }
}
