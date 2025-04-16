<?php


namespace App\Channels\Messages;

class WhatsAppMessage
{
  public $contentVariables = [];
  public $templateSid = "";

  public function __construct($templateSid)
  {
    $this->templateSid = $templateSid;
  }

  public function customer($customer)
  {
    $this->contentVariables['customer'] = $customer;    
    return $this;
  }

  public function names($names)
  {
    $this->contentVariables['names'] = $names;
    return $this;
  }

  public function hall($hall)
  {
    $this->contentVariables['hall'] = $hall;
    return $this;
  }

  public function date($date)
  {
    $this->contentVariables['date'] = $date;
    return $this;
  }

  public function messageMedia($messageMedia)
  {
    $this->contentVariables['message_media'] = $messageMedia;
    return $this;
  }
}