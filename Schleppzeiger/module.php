<?php

declare(strict_types=1);
class Schleppzeiger extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyInteger('Target', 0);
        $this->RegisterPropertyInteger('Interval', 0);
        $this->RegisterPropertyString('Option', 'Maximum');

        if (!IPS_VariableProfileExists('SZ.Reset')) {
            IPS_CreateVariableProfile('SZ.Reset', VARIABLETYPE_BOOLEAN);
            IPS_SetVariableProfileAssociation('SZ.Reset', true, $this->Translate('Reset'), '', 0x00FF00);
        }

        $this->RegisterVariableFloat('TrailingPointer', $this->Translate('Trailing Pointer'), '', 0);
        $this->RegisterVariableBoolean('Reset', $this->Translate('Reset'), 'SZ.Reset', 1);
        $this->EnableAction('Reset');

        $this->RegisterTimer('ResetTimer', 0, 'SZ_Reset($_IPS[\'TARGET\']);');
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

        $targetID = $this->ReadPropertyInteger('Target');
        if (!IPS_VariableExists($targetID)) {
            $this->SetStatus(200); //Target Variable is not valid
            return;
        }
        $this->SetStatus(102);

        //Reference
        //Unregister
        foreach ($this->GetReferenceList() as $id) {
            $this->UnregisterReference($id);
        }

        //Register
        $this->RegisterReference($targetID);

        //Messages
        //Unregister all messages
        foreach ($this->GetMessageList() as $senderID => $messages) {
            foreach ($messages as $message) {
                $this->UnregisterMessage($senderID, $message);
            }
        }

        //Register necessary messages
        $this->RegisterMessage($this->GetIDForIdent('Reset'), VM_UPDATE);
        $this->RegisterMessage($targetID, VM_UPDATE);

        //Set TimerInterval
        $this->SetTimerInterval('ResetTimer', $this->ReadPropertyInteger('Interval') * 1000);
    }

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'Reset':
                $this->Reset();
                break;
            default:
                $this->SetValue($Ident, $Value);
                break;
        }
    }

    public function Reset()
    {
        $this->SetValue('TrailingPointer', GetValue($this->ReadPropertyInteger('Target')));
        $this->SetTimerInterval('ResetTimer', $this->ReadPropertyInteger('Interval') * 1000);
    }

    public function MessageSink($timestamp, $sendId, $messageID, $data)
    {
        if ($messageID == VM_UPDATE) {
            if ($sendId == $this->GetIDForIdent('Reset')) {
                $this->Reset();
            } elseif ($sendId == $this->ReadPropertyInteger('Target')) {
                $this->trailingTarget($data[0]);
            }
        }
    }

    private function trailingTarget($value)
    {
        $currentValue = $this->GetValue('TrailingPointer');

        switch ($this->ReadPropertyString('Option')) {
            case 'Maximum':
                if ($value > $currentValue) {
                    $this->SetValue('TrailingPointer', $value);
                }
                break;
            case 'Minimum':
                if ($value < $currentValue) {
                    $this->SetValue('TrailingPointer', $value);
                }
                break;
            default:
                $this->SendDebug('Not Supported', 'Current Option is not supported', 0);
                break;
        }
    }
}