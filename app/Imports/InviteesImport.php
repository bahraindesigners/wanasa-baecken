<?php

namespace App\Imports;

use App\Enums\InviteeNotificationStatus;
use App\Models\Invitee;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InviteesImport implements ToModel, WithHeadingRow
{

    protected ?int $eventId = null;
    
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info($row);
        if(!isset($row["name"]) || !isset($row["phone"])) return;
        return new Invitee([
            'name' => $row["name"],
            'phone' => $row["phone"],
            'status' => InviteeNotificationStatus::PENDING,
            'event_id' => $this->eventId,
            'qr_token' => $this->eventId . '_' . $row["phone"] . '_' . uniqid()
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ];
    }
}
