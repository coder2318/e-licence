<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  int $id
 * @property  int $application_id
 * @property  int $old_status
 * @property  int $new_status
 */

class ApplicationHistory extends Model
{
    use HasFactory;

    protected $appends = [
        'old_status_text',
        'new_status_text',
    ];

    public function getOldStatusTextAttribute(): string
    {
        return match ($this->old_status) {
            Application::NEW => 'new',
            Application::AT_MODERATOR => 'at_moderator',
            Application::AT_COUNCIL => 'at_council',
            Application::AT_MINISTRY => 'at_ministry',
            Application::SUCCESS => 'success',
            Application::CANCEL_BY_MODERATOR => 'cancel_by_moderator',
            Application::CANCEL_BY_COUNCIL => 'cancel_by_council',
            Application::CANCEL_BY_MINISTRY => 'cancel_by_ministry',
            default => 'error',
        };
    }

    public function getNewStatusTextAttribute(): string
    {
        return match ($this->new_status) {
            Application::NEW => 'new',
            Application::AT_MODERATOR => 'at_moderator',
            Application::AT_COUNCIL => 'at_council',
            Application::AT_MINISTRY => 'at_ministry',
            Application::SUCCESS => 'success',
            Application::CANCEL_BY_MODERATOR => 'cancel_by_moderator',
            Application::CANCEL_BY_COUNCIL => 'cancel_by_council',
            Application::CANCEL_BY_MINISTRY => 'cancel_by_ministry',
            default => 'error',
        };
    }
}
