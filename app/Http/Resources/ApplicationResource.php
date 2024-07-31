<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        $title  = __('microloan.business_microloan_title');
        return [
            'id'               => $this->id,
            'title'            =>  $this->loan? $this->loan->title[$this->getLang()]??$title:$title,
            'status'           => __('microloan.' . $this->status_text),
            'scoring_amount'   => $this->scoring_amount,
            'card'             => $this->card_secure,
            'bpr_id'           => $this->bpr_id,
            'error'            => $this->getError(),
            'error_message'    => $this->getErrorMessage(),
            'available_amount' => $this->getAvailableAmount(),
            'status_code'      => $this->status,
            'card_id'          => $this->card_id,
            'created_at'       => $this->created_at,
            'provision'        => $this->lastProvision
                ? new LoanProvisionResource($this->lastProvision)
                : null,
        ];
    }

    public function getLang(): string
    {
        return app()->getLocale();
    }
}
