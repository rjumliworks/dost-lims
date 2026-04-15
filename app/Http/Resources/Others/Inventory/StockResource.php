<?php

namespace App\Http\Resources\Others\Inventory;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        

        $code = $this->code;
        $result = new Builder(
            writer: new PngWriter(),
            data: $code,
            size: 300,
            margin: 10,
        );
        $qrCodeImageString = $result->build()->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        // $qrCode = new QrCode($code);
        // $qrCode->setSize(300);
        // $pngWriter = new PngWriter();
        // $qrCodeImageString = $pngWriter->write($qrCode)->getString();
        // $qr = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'old_code' => $this->old_code,
            'name' => $this->item->name,
            'brand' => ($this->brand) ? $this->brand : "Not specified",
            'quantity' => $this->quantity,
            'onhand' => $this->onhand,
            'number' => $this->number,
            'unit' => $this->unit,
            'unit_id' => $this->unit_id,
            'type' => $this->unittype->name,
            'price' => $this->price,
            'supplier' => ($this->supp) ? $this->supp->name : $this->supplier, 
            'supplier_id' => $this->supplier_id,
            'supplier_data' => $this->supp,
            'bought_at' => $this->bought_at,
            'expired_at' => $this->expired_at,
            'withdrawals' => $this->withdrawals,
            'qr' => $base64Image
        ];
    }
}
